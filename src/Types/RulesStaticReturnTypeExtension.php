<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\Type;

/**
 * Narrows `parent::rules()` — the subclass shape that motivated this extension:
 * a base request declares only `schema()`, the child calls
 * `parent::rules()->merge([...])`.
 *
 * `parent::rules()` parses as a {@see StaticCall}, which
 * {@see RulesReturnTypeExtension} never sees — dynamic *method* return type
 * extensions are only consulted for {@see MethodCall}.
 *
 * The class is taken from the scope, not from the call's class name: for
 * `parent::rules()` the name resolves to the base class, but `schema()` must be
 * looked up on the class being analysed so an override on the child wins and an
 * inherited `schema()` still resolves.
 */
final readonly class RulesStaticReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    public function __construct(private SchemaRulesResolver $resolver) {}

    public function getClass(): string
    {
        return FormRequest::class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'rules';
    }

    public function getTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope,
    ): ?Type {
        if (! $this->resolver->isTraitFallback($methodReflection)) {
            return null;
        }

        $classReflection = $this->targetClass($methodCall, $scope);

        if (! $classReflection instanceof ClassReflection) {
            return null;
        }

        return $this->resolver->resolve($classReflection, $scope);
    }

    /**
     * The class whose `schema()` decides the type.
     *
     * For `parent::`, `self::` and `static::` that is the class being analysed,
     * not the name the call resolves to — `parent::rules()` names the base
     * class, but an override of `schema()` on the child has to win. Any other
     * class name is resolved on its own merits, so an unrelated
     * `SomeRequest::rules()` is not silently answered with the enclosing
     * class's schema.
     */
    private function targetClass(StaticCall $methodCall, Scope $scope): ?ClassReflection
    {
        if (! $methodCall->class instanceof Name) {
            return null;
        }

        if (in_array($methodCall->class->toLowerString(), ['parent', 'self', 'static'], true)) {
            return $scope->getClassReflection();
        }

        $classReflections = $scope->resolveTypeByName($methodCall->class)->getObjectClassReflections();

        return count($classReflections) === 1 ? $classReflections[0] : null;
    }
}
