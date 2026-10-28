<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Parser;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Variable;
use PhpParser\NodeVisitorAbstract;

/**
 * Replaces every read of one variable with a fixed expression. Used on a cloned
 * `schema()` body so the injected `FluentSchema $rules` parameter types
 * correctly in a scope that never entered the method.
 */
final class VariableReplacingVisitor extends NodeVisitorAbstract
{
    public function __construct(
        private readonly string $variableName,
        private readonly Expr $replacement,
    ) {}

    public function leaveNode(Node $node): ?Node
    {
        if ($node instanceof Variable && $node->name === $this->variableName) {
            return $this->replacement;
        }

        return null;
    }
}
