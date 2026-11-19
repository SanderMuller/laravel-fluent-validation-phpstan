<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Parser;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\NodeVisitorAbstract;

final class FluentValidationChainVisitor extends NodeVisitorAbstract
{
    public const CHAIN_ATTR = 'fluentValidation.chain';

    public const CHAIN_ROOT_ATTR = 'fluentValidation.chainRoot';

    public const RULE_ARGS_ATTR = 'fluentValidation.ruleArgs';

    /**
     * The innermost MethodCall of a chain whose root is not a static call or a
     * `new`: `$rules->array()` in `$rules->array()->each(...)`, where the root
     * is the `$rules` variable. Only set in that case.
     */
    public const CHAIN_SEED_ATTR = 'fluentValidation.chainSeed';

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
        $innermost = $outermost;

        while ($current instanceof MethodCall) {
            $innermost = $current;
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

            $current = $current->var;
            $this->markInner($current);
        }

        // Early exit: no 'each' call in this chain — nothing to annotate.
        if ($eachHops === []) {
            return;
        }

        $this->stampEachHops($eachHops, $chainMethods, $current, $ruleArgs, $innermost);
    }

    /**
     * @param  list<MethodCall>  $eachHops
     * @param  list<string|null>  $chainMethods
     * @param  list<Node\Expr>  $ruleArgs
     */
    private function stampEachHops(array $eachHops, array $chainMethods, Node $root, array $ruleArgs, MethodCall $innermost): void
    {
        $seed = $root instanceof StaticCall || $root instanceof New_ ? null : $innermost;

        foreach ($eachHops as $hop) {
            $hop->setAttribute(self::CHAIN_ATTR, $chainMethods);
            $hop->setAttribute(self::CHAIN_ROOT_ATTR, $root);
            $hop->setAttribute(self::RULE_ARGS_ATTR, $ruleArgs);

            if ($seed instanceof MethodCall) {
                $hop->setAttribute(self::CHAIN_SEED_ATTR, $seed);
            }
        }
    }

    /**
     * Mark an inner hop so enterNode skips it — this replaces the
     * parent-tracking stack from the previous approach.
     */
    private function markInner(Node $node): void
    {
        if ($node instanceof MethodCall) {
            $node->setAttribute(self::INNER_ATTR, true);
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
