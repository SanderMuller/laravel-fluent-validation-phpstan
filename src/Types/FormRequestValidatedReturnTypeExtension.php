<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\NullType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * Narrows `$request->validated()` on a fluent FormRequest to the shape its
 * rules enforce, and `validated('key')` to that key's value type.
 *
 * Anchored on {@see FormRequest} because PHPStan never matches an extension
 * against a trait; {@see FormRequestShapeResolver} checks for
 * `HasFluentRules`.
 */
final readonly class FormRequestValidatedReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function __construct(
        private FormRequestShapeResolver $resolver,
        private CallArguments $arguments,
    ) {}

    public function getClass(): string
    {
        return FormRequest::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'validated';
    }

    public function getTypeFromMethodCall(
        MethodReflection $methodReflection,
        MethodCall $methodCall,
        Scope $scope,
    ): ?Type {
        if ($methodCall->isFirstClassCallable()) {
            return null;
        }

        $classReflections = $scope->getType($methodCall->var)->getObjectClassReflections();

        if (count($classReflections) !== 1) {
            return null;
        }

        $shape = $this->resolver->resolve($classReflections[0]);

        if (! $shape instanceof Type) {
            return null;
        }

        $key = $this->arguments->value($methodCall, 'key', 0);

        if (! $key instanceof Expr) {
            return $methodCall->getArgs() === [] ? $shape : null;
        }

        if ($scope->getType($key)->isNull()->yes()) {
            return $shape;
        }

        return $this->keyType($shape, $key, $methodCall, $scope);
    }

    /**
     * `data_get()` returns the default whenever the key is absent, and runs a
     * Closure default through `value()`, so a default that may be a Closure is
     * not typed.
     */
    private function keyType(Type $shape, Expr $key, MethodCall $methodCall, Scope $scope): ?Type
    {
        $keys = $scope->getType($key)->getConstantStrings();

        if (count($keys) !== 1 || str_contains($keys[0]->getValue(), '.') || str_contains($keys[0]->getValue(), '*')) {
            return null;
        }

        $default = $this->arguments->value($methodCall, 'default', 1);
        $defaultType = $default instanceof Expr ? $scope->getType($default) : new NullType();

        if (! (new ObjectType(Closure::class))->isSuperTypeOf($defaultType)->no()) {
            return null;
        }

        $offset = new ConstantStringType($keys[0]->getValue());
        $hasOffset = $shape->hasOffsetValueType($offset);

        if ($hasOffset->no()) {
            return $defaultType;
        }

        $valueType = $shape->getOffsetValueType($offset);

        return $hasOffset->yes() ? $valueType : TypeCombinator::union($valueType, $defaultType);
    }
}
