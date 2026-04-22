<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Parser;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\NodeVisitorAbstract;

final class FluentValidationChainVisitor extends NodeVisitorAbstract
{
    public const CHAIN_ATTR = 'fluentValidation.chain';

    public const CHAIN_ROOT_ATTR = 'fluentValidation.chainRoot';

    public const RULE_ARGS_ATTR = 'fluentValidation.ruleArgs';

    /** @var list<Node> */
    private array $stack = [];

    /**
     * PHPStan reuses the visitor service across files. `beforeTraverse` runs at the
     * start of every file's traversal — reset the ancestor stack defensively so a
     * half-finished traversal (e.g. interrupted by a parse error) can't leak state
     * into the next file.
     *
     * @param  array<Node>  $nodes
     */
    public function beforeTraverse(array $nodes): ?array
    {
        $this->stack = [];

        return null;
    }

    public function enterNode(Node $node): ?Node
    {
        if ($node instanceof MethodCall && $this->isOutermostChainCall($node)) {
            $this->annotateChain($node);
        }

        $this->stack[] = $node;

        return null;
    }

    public function leaveNode(Node $node): ?Node
    {
        array_pop($this->stack);

        return null;
    }

    private function isOutermostChainCall(MethodCall $node): bool
    {
        $parent = $this->stack[count($this->stack) - 1] ?? null;

        return ! $parent instanceof MethodCall || $parent->var !== $node;
    }

    private function annotateChain(MethodCall $outermost): void
    {
        $hops = $this->collectHops($outermost);
        $root = $this->resolveRoot($outermost);
        $chainMethods = $this->collectMethodNames($hops);
        $ruleArgs = $this->collectRuleArgs($hops);

        foreach ($hops as $hop) {
            if ($this->hopMethodName($hop) === 'each') {
                $hop->setAttribute(self::CHAIN_ATTR, $chainMethods);
                $hop->setAttribute(self::CHAIN_ROOT_ATTR, $root);
                $hop->setAttribute(self::RULE_ARGS_ATTR, $ruleArgs);
            }
        }
    }

    /**
     * @param  list<MethodCall>  $hops
     * @return list<string|null>
     */
    private function collectMethodNames(array $hops): array
    {
        $names = [];
        foreach ($hops as $hop) {
            $names[] = $this->hopMethodName($hop);
        }

        return $names;
    }

    /**
     * @param  list<MethodCall>  $hops
     * @return list<Expr>
     */
    private function collectRuleArgs(array $hops): array
    {
        $args = [];
        foreach ($hops as $hop) {
            if ($this->hopMethodName($hop) !== 'rule') {
                continue;
            }

            $first = $hop->args[0] ?? null;
            if ($first instanceof Arg) {
                $args[] = $first->value;
            }
        }

        return $args;
    }

    /** @return list<MethodCall> ordered innermost-first (closest to root). */
    private function collectHops(MethodCall $outermost): array
    {
        $hops = [];
        $current = $outermost;

        while ($current instanceof MethodCall) {
            $hops[] = $current;
            $current = $current->var;
        }

        return array_reverse($hops);
    }

    private function resolveRoot(MethodCall $outermost): Node
    {
        $current = $outermost;

        while ($current instanceof MethodCall) {
            $current = $current->var;
        }

        return $current;
    }

    private function hopMethodName(MethodCall $hop): ?string
    {
        if (! $hop->name instanceof Identifier) {
            return null;
        }

        return strtolower($hop->name->toString());
    }
}
