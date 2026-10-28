<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\Type;

/**
 * Narrows `$request->rules()` to the concrete class's `schema()` return type.
 *
 * Anchored on {@see FormRequest} rather than `HasFluentRules`: PHPStan resolves
 * dynamic return type extensions against the class, its parents and its
 * interfaces only — never its traits — so a trait-anchored extension would
 * silently never run.
 *
 * `parent::rules()` is a static call and is handled by
 * {@see RulesStaticReturnTypeExtension}.
 */
final readonly class RulesReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function __construct(private SchemaRulesResolver $resolver) {}

    public function getClass(): string
    {
        return FormRequest::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'rules';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope,
    ): ?Type {
        if (! $this->resolver->isTraitFallback($methodReflection)) {
            return null;
        }

        $classReflections = $scope->getType($methodCall->var)->getObjectClassReflections();

        if (count($classReflections) !== 1) {
            return null;
        }

        return $this->resolver->resolve($classReflections[0], $scope);
    }
}
