<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\CloningVisitor;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Type;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\LaravelFluentValidationPhpstan\Parser\VariableReplacingVisitor;

/**
 * Reads a rules array that lives in another method body, such as a
 * FormRequest's `schema()`, into its validated shape.
 *
 * The array is deep-cloned first: the parser shares its cached AST with
 * PHPStan's own analysis of that file. In the clone, the injected
 * `FluentSchema` parameter is replaced with `new FluentSchema()` so its chains
 * type correctly in a scope that never entered the method.
 */
final readonly class RuleSetArrayReader
{
    public function __construct(private ValidatedShapeResolver $shapeResolver) {}

    public function read(Array_ $rules, ?string $schemaVariable, Scope $scope): ?Type
    {
        $visitors = [new CloningVisitor()];

        if ($schemaVariable !== null) {
            $visitors[] = new VariableReplacingVisitor($schemaVariable, new New_(new FullyQualified(FluentSchema::class)));
        }

        $cloned = (new NodeTraverser(...$visitors))->traverse([$rules])[0] ?? null;

        return $cloned instanceof Array_ ? $this->shapeResolver->resolve($cloned, $scope) : null;
    }
}
