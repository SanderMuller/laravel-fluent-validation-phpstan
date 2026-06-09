<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Parser;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\NodeVisitorAbstract;

final class FluentValidationChainVisitor extends NodeVisitorAbstract
{
    public const CHAIN_ATTR = 'fluentValidation.chain';

    public const CHAIN_ROOT_ATTR = 'fluentValidation.chainRoot';

    public const RULE_ARGS_ATTR = 'fluentValidation.ruleArgs';

    /**
     * Set on every non-outermost MethodCall in a chain so that `enterNode` can
     * skip them without maintaining a parent-tracking stack.
     *
     * A MethodCall is "inner" when it is the `.var` child of another MethodCall —
     * i.e. it is never the outermost call in its chain. This attribute is stamped
     * during `annotateChain`, which is always called before PHP-Parser descends
     * into the inner nodes (parent-before-children traversal order).
     */
    private const INNER_ATTR = 'fluentValidation.inner';

    public function enterNode(Node $node): ?Node
    {
        if (! $node instanceof MethodCall) {
            return null;
        }

        if ($node->getAttribute(self::INNER_ATTR) !== true) {
            $this->annotateChain($node);
        }

        return null;
    }

    private function annotateChain(MethodCall $outermost): void
    {
        // Single traversal: collect chain metadata while checking for 'each'.
        // Mark inner hops and gather rule args inline to avoid extra passes.
        $chainMethods = [];
        $eachHops = [];
        $ruleArgs = [];
        $current = $outermost;

        while ($current instanceof MethodCall) {
            $name = $this->hopMethodName($current);
            $chainMethods[] = $name;

            if ($name === 'each') {
                $eachHops[] = $current;
            } elseif ($name === 'rule') {
                $first = $current->args[0] ?? null;
                if ($first instanceof Arg) {
                    $ruleArgs[] = $first->value;
                }
            }

            $next = $current->var;
            if ($next instanceof MethodCall) {
                // Mark the inner hop so enterNode skips it — this replaces the
                // parent-tracking stack from the previous approach.
                $next->setAttribute(self::INNER_ATTR, true);
            }

            $current = $next;
        }

        // Early exit: no 'each' call in this chain — nothing to annotate.
        if ($eachHops === []) {
            return;
        }

        $root = $current;

        foreach ($eachHops as $hop) {
            $hop->setAttribute(self::CHAIN_ATTR, $chainMethods);
            $hop->setAttribute(self::CHAIN_ROOT_ATTR, $root);
            $hop->setAttribute(self::RULE_ARGS_ATTR, $ruleArgs);
        }
    }

    private function hopMethodName(MethodCall $hop): ?string
    {
        if (! $hop->name instanceof Identifier) {
            return null;
        }

        return $hop->name->toLowerString();
    }
}
