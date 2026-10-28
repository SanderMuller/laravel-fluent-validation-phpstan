<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use Closure;
use Illuminate\Contracts\Validation\CompilableRules;
use Illuminate\Validation\ConditionalRules;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;

/**
 * Classifies the argument of a `->rule(...)` hop.
 *
 * A rule only narrows the value unless it is one of Laravel's presence rules,
 * so the argument is matched by rule name: `required` and `nullable` act like
 * their fluent methods, the `exclude`/`sometimes`/`required_*`/`prohibited`/
 * `missing`/`present`/`filled` family makes the key optional, and every other
 * rule is a plain constraint. An argument that is not one certain value, or a
 * `Rule::when()` / compilable rule that expands into arbitrary rules, is
 * unreadable.
 */
final readonly class RuleArgumentClassifier
{
    /** @var list<string> */
    private const array CONDITIONAL_RULE_PREFIXES = ['exclude', 'sometimes', 'required_', 'prohibit', 'missing', 'present', 'filled'];

    /** @var list<string> */
    private const array CONDITIONAL_OBJECT_PREFIXES = ['Exclude', 'Missing', 'Present', 'Prohibit', 'Required'];

    private const string LARAVEL_RULES_NAMESPACE = 'Illuminate\\Validation\\Rules\\';

    public function __construct(private CallArguments $arguments) {}

    /**
     * @return list<ModifierEffect>|null
     */
    public function classify(MethodCall $hop, Scope $scope): ?array
    {
        $argument = $this->arguments->value($hop, 'rule', 0);

        if (! $argument instanceof Expr) {
            return null;
        }

        $type = $scope->getType($argument);

        if ($type->isObject()->yes()) {
            return $this->classifyObject($type);
        }

        $constantArrays = $type->getConstantArrays();

        if (count($constantArrays) === 1) {
            $type = $constantArrays[0]->getOffsetValueType(new ConstantIntegerType(0));
        }

        $constantStrings = $type->getConstantStrings();

        return count($constantStrings) === 1 ? $this->classifyRuleString($constantStrings[0]->getValue()) : null;
    }

    /**
     * @return list<ModifierEffect>
     */
    private function classifyRuleString(string $rules): array
    {
        $effects = [];

        foreach (explode('|', $rules) as $rule) {
            $effects[] = $this->classifyRuleName(strtolower(explode(':', $rule, 2)[0]));
        }

        return $effects;
    }

    private function classifyRuleName(string $name): ModifierEffect
    {
        if ($name === 'required') {
            return ModifierEffect::Required;
        }

        if ($name === 'nullable') {
            return ModifierEffect::Nullable;
        }

        return $this->startsWithAny($name, self::CONDITIONAL_RULE_PREFIXES)
            ? ModifierEffect::Conditional
            : ModifierEffect::Constraint;
    }

    /**
     * @return list<ModifierEffect>|null
     */
    private function classifyObject(Type $type): ?array
    {
        if ((new ObjectType(Closure::class))->isSuperTypeOf($type)->yes()) {
            return [ModifierEffect::Constraint];
        }

        $classReflections = $type->getObjectClassReflections();

        if ($classReflections === []) {
            return null;
        }

        $effect = ModifierEffect::Constraint;

        foreach ($classReflections as $classReflection) {
            if ($classReflection->is(CompilableRules::class) || $classReflection->is(ConditionalRules::class)) {
                return null;
            }

            if ($this->isLaravelPresenceRule($classReflection->getName())) {
                $effect = ModifierEffect::Conditional;
            }
        }

        return [$effect];
    }

    /**
     * `Rule::excludeIf()`, `Rule::requiredIf()`, `Rule::prohibitedIf()` and
     * their siblings compile to presence rules.
     */
    private function isLaravelPresenceRule(string $className): bool
    {
        if (! str_starts_with($className, self::LARAVEL_RULES_NAMESPACE)) {
            return false;
        }

        $shortName = substr($className, strlen(self::LARAVEL_RULES_NAMESPACE));

        return $this->startsWithAny($shortName, self::CONDITIONAL_OBJECT_PREFIXES);
    }

    /**
     * @param  list<string>  $prefixes
     */
    private function startsWithAny(string $subject, array $prefixes): bool
    {
        return array_filter($prefixes, static fn (string $prefix): bool => str_starts_with($subject, $prefix)) !== [];
    }
}
