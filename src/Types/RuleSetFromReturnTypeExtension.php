<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\DynamicStaticMethodReturnTypeExtension;
use PHPStan\Type\Generic\GenericObjectType;
use PHPStan\Type\Type;
use SanderMuller\FluentValidation\RuleSet;

/**
 * Narrows `RuleSet::from([...])` to `RuleSet<array{...}>`, so `validate()` and
 * `check()->validated()` return the shape the rules enforce at runtime instead
 * of `array<string, mixed>`.
 *
 * Inert against a `laravel-fluent-validation` release whose `RuleSet` is not
 * generic yet: building a `GenericObjectType` on a non-generic class would
 * report a bogus type.
 */
final readonly class RuleSetFromReturnTypeExtension implements DynamicStaticMethodReturnTypeExtension
{
    public function __construct(private ValidatedShapeResolver $resolver) {}

    public function getClass(): string
    {
        return RuleSet::class;
    }

    public function isStaticMethodSupported(MethodReflection $methodReflection): bool
    {
        return $methodReflection->getName() === 'from';
    }

    public function getTypeFromStaticMethodCall(
        MethodReflection $methodReflection,
        StaticCall $methodCall,
        Scope $scope,
    ): ?Type {
        if (! $methodReflection->getDeclaringClass()->isGeneric() || $methodCall->isFirstClassCallable()) {
            return null;
        }

        $rules = $this->rulesArgument($methodCall->getArgs());

        if (! $rules instanceof Array_) {
            return null;
        }

        $shape = $this->resolver->resolve($rules, $scope);

        return $shape instanceof Type ? new GenericObjectType(RuleSet::class, [$shape]) : null;
    }

    /**
     * @param  array<Arg>  $args
     */
    private function rulesArgument(array $args): ?Array_
    {
        if (count($args) !== 1 || $args[0]->unpack) {
            return null;
        }

        $arg = $args[0];

        if ($arg->name instanceof Identifier && $arg->name->toString() !== 'rules') {
            return null;
        }

        return $arg->value instanceof Array_ ? $arg->value : null;
    }
}
