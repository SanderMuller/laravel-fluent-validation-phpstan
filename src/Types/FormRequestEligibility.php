<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use Illuminate\Foundation\Http\FormRequest;
use PHPStan\Reflection\ClassReflection;
use SanderMuller\FluentValidation\HasFluentRules;

/**
 * Whether a FormRequest's `validated()` shape can be read from its own rules
 * body.
 *
 * Only a `final` class qualifies. A method body says nothing about a subclass,
 * which can override `schema()` or add a `rules()` the trait merges in, so
 * typing an extensible class from its own body could be narrower than
 * runtime. A class that replaces the validator or rewrites the validated data
 * after validation does not qualify either; `prepareForValidation()` only
 * changes the input the rules then check, so it is allowed.
 */
final readonly class FormRequestEligibility
{
    /**
     * Methods that, declared anywhere below {@see FormRequest}, can change
     * which rules run or what `validated()` returns. `HasFluentRules`'s own
     * `createDefaultValidator()` is expected and allowed.
     *
     * @var list<string>
     */
    private const array VALIDATION_HOOKS = ['passedValidation', 'validated', 'validator', 'createDefaultValidator', 'getValidatorInstance'];

    public function isEligible(ClassReflection $classReflection): bool
    {
        return $classReflection->isFinal()
            && $this->usesFluentRules($classReflection)
            && ! $this->overridesValidation($classReflection);
    }

    private function usesFluentRules(ClassReflection $classReflection): bool
    {
        return array_key_exists(HasFluentRules::class, $classReflection->getTraits(true));
    }

    private function overridesValidation(ClassReflection $classReflection): bool
    {
        foreach (self::VALIDATION_HOOKS as $hook) {
            if ($this->isOverridden($classReflection, $hook)) {
                return true;
            }
        }

        return false;
    }

    private function isOverridden(ClassReflection $classReflection, string $methodName): bool
    {
        $nativeClass = $classReflection->getNativeReflection();

        if (! $nativeClass->hasMethod($methodName)) {
            return false;
        }

        $nativeMethod = $nativeClass->getMethod($methodName);

        if ($nativeMethod->getDeclaringClass()->getName() === FormRequest::class) {
            return false;
        }

        $trait = $classReflection->getTraits(true)[HasFluentRules::class] ?? null;

        return $trait === null || $nativeMethod->getFileName() !== $trait->getFileName();
    }
}
