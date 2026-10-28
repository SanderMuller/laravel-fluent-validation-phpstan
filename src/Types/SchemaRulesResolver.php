<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPStan\Type\UnionType;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

/**
 * Shared narrowing logic for `HasFluentRules::rules()`, used by both the
 * instance-call and static-call ({@see parent::rules()}) extensions.
 *
 * The trait's fallback `rules()` is a verbatim pass-through of
 * `Container::call([$this, 'schema'])`, so the two types are the same value.
 * Its declared union `array<string, mixed>|RuleSet` is as wide as the widest
 * permitted `schema()`, which loses the per-class narrowing every caller needs.
 */
final class SchemaRulesResolver
{
    /**
     * Whether `rules()` is still the trait's own fallback rather than a
     * consumer-declared override. A class that declares its own `rules()`
     * narrows the return type itself, and when it declares both `rules()` and
     * `schema()` the trait merges them — neither case may be overwritten here.
     *
     * Matched structurally (a union of an array and `RuleSet`) rather than by
     * `equals()` against a hand-built type. How the trait's `@return
     * array<string, mixed>` resolves — `array` vs `array<string, mixed>`,
     * explicit vs implicit `mixed` — varies with the analysed project's PHPStan
     * configuration, and an `equals()` guard that misses silently leaves the
     * extension inert rather than failing loudly.
     */
    public function isTraitFallback(MethodReflection $methodReflection): bool
    {
        if (! $this->isDeclaredByTrait($methodReflection)) {
            return false;
        }

        return $this->isTraitFallbackReturnType($methodReflection->getVariants()[0]->getReturnType());
    }

    /**
     * Whether `rules()` comes from `HasFluentRules` rather than the class's own
     * body. The return type alone cannot tell the two apart — a consumer is free
     * to declare `rules(): array|RuleSet` themselves, and that method returns
     * whatever they wrote, not `schema()`'s value.
     *
     * PHPStan reports a trait method's declaring class as the *using* class, so
     * the discriminator is the file: a trait method's native reflection points
     * at the trait's file, an own declaration at the class's own file.
     */
    private function isDeclaredByTrait(MethodReflection $methodReflection): bool
    {
        $nativeClass = $methodReflection->getDeclaringClass()->getNativeReflection();

        if (! $nativeClass->hasMethod($methodReflection->getName())) {
            return false;
        }

        $declaredIn = $nativeClass->getMethod($methodReflection->getName())->getFileName();

        foreach ($methodReflection->getDeclaringClass()->getTraits(true) as $trait) {
            if ($trait->getName() === HasFluentRules::class) {
                return $declaredIn !== false && $declaredIn === $trait->getFileName();
            }
        }

        return false;
    }

    /**
     * Split out from {@see isTraitFallback()} so the accepted shapes can be
     * asserted directly. A fixture-driven type-inference test only ever sees
     * whichever shape this repo's own PHPStan config produces, so it cannot
     * pin the tolerance that keeps the guard working in a consumer project.
     */
    public function isTraitFallbackReturnType(Type $returnType): bool
    {
        if (! $returnType instanceof UnionType) {
            return false;
        }

        $ruleSet = new ObjectType(RuleSet::class);
        $hasArray = false;
        $hasRuleSet = false;

        foreach ($returnType->getTypes() as $type) {
            $hasArray = $hasArray || $type->isArray()->yes();
            $hasRuleSet = $hasRuleSet || $ruleSet->isSuperTypeOf($type)->yes();
        }

        return $hasArray && $hasRuleSet;
    }

    /**
     * The concrete class's `schema()` return type, or `array{}` when the trait
     * would short-circuit to `[]`.
     */
    public function resolve(ClassReflection $classReflection, Scope $scope): Type
    {
        if (! $classReflection->hasMethod('schema')) {
            return $this->emptyRules();
        }

        $variant = $classReflection->getMethod('schema', $scope)->getVariants()[0];
        $parameters = $variant->getParameters();

        /**
         * Mirrors the trait's `schemaExpectsFluentSchema()` gate, so an
         * unrelated `schema()` — a JSON or DB schema getter — is never hijacked.
         * Null is stripped first because the runtime gate reads
         * `ReflectionNamedType::getName()`, which reports `FluentSchema` for a
         * `?FluentSchema` parameter and so accepts it.
         */
        if (! isset($parameters[0])) {
            return $this->emptyRules();
        }

        $firstParameter = TypeCombinator::removeNull($parameters[0]->getType());

        if (! $firstParameter->equals(new ObjectType(FluentSchema::class))) {
            return $this->emptyRules();
        }

        return $variant->getReturnType();
    }

    /**
     * Whether the class has a `schema()` whose first parameter is a
     * `FluentSchema`, the same gate {@see resolve()} and the trait apply.
     */
    public function hasFluentSchema(ClassReflection $classReflection): bool
    {
        if (! $classReflection->hasNativeMethod('schema')) {
            return false;
        }

        $parameters = $classReflection->getNativeMethod('schema')->getVariants()[0]->getParameters();

        return isset($parameters[0])
            && TypeCombinator::removeNull($parameters[0]->getType())->equals(new ObjectType(FluentSchema::class));
    }

    /**
     * The trait returns `[]` whenever it has no FluentSchema-shaped `schema()`.
     */
    private function emptyRules(): ConstantArrayType
    {
        return new ConstantArrayType([], []);
    }
}
