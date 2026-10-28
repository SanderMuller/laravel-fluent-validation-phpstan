<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;

/**
 * Classifies the modifier hops of a rule chain for {@see RuleChainReader}.
 *
 * Presence and value are judged separately. A hop keeps the key's presence
 * when it is a native method of the rule class, is not a presence modifier and
 * is not `when()`/`unless()`/`whenInput()`, which could add `sometimes` or
 * `exclude` behind the analyser's back; a macro or a dynamic name makes the
 * whole chain unreadable. The value keeps its base type only while every hop
 * is a known constraint from the allowlist below; any other native hop leaves
 * the key's presence intact but reads its value as `mixed`.
 */
final readonly class RuleChainModifiers
{
    public function __construct(
        private CallArguments $arguments,
        private RuleArgumentClassifier $ruleArguments,
    ) {}

    /**
     * Lower-cased names of the methods that only add a constraint the value
     * must also pass.
     *
     * @var array<string, true>
     */
    private const array CONSTRAINTS = [
        // HasFieldModifiers, FieldRule, HasEmbeddedRules
        'label' => true, 'message' => true, 'messagefor' => true, 'fieldmessage' => true, 'bail' => true,
        'same' => true, 'different' => true, 'confirmed' => true, 'unique' => true, 'exists' => true,
        'enum' => true, 'in' => true, 'notin' => true, 'inarray' => true, 'inarraykeys' => true,
        'distinct' => true, 'between' => true, 'exactly' => true, 'max' => true, 'min' => true,
        // StringRule
        'alpha' => true, 'alphadash' => true, 'alphanumeric' => true, 'ascii' => true, 'encoding' => true,
        'doesntendwith' => true, 'doesntstartwith' => true, 'endswith' => true, 'startswith' => true,
        'lowercase' => true, 'uppercase' => true, 'url' => true, 'activeurl' => true, 'uuid' => true,
        'ulid' => true, 'json' => true, 'ip' => true, 'ipv4' => true, 'ipv6' => true, 'macaddress' => true,
        'regex' => true, 'notregex' => true, 'timezone' => true, 'hexcolor' => true, 'date' => true,
        'email' => true, 'dateformat' => true, 'currentpassword' => true,
        // NumericRule
        'decimal' => true, 'digits' => true, 'digitsbetween' => true, 'greaterthan' => true,
        'greaterthanorequalto' => true, 'lessthan' => true, 'lessthanorequalto' => true,
        'maxdigits' => true, 'mindigits' => true, 'multipleof' => true, 'positive' => true,
        'negative' => true, 'nonnegative' => true, 'nonpositive' => true,
        // BooleanRule
        'accepted' => true, 'acceptedif' => true, 'declined' => true, 'declinedif' => true,
    ];

    /**
     * Prefixes of the presence modifiers that can leave the key out of
     * `validated()`. {@see isConditional()} excludes `required()` itself, so the
     * `required` prefix only catches `requiredIf()`, `requiredWith()` and the
     * rest of the conditional family.
     *
     * @var list<string>
     */
    private const array CONDITIONAL_PREFIXES = ['sometimes', 'filled', 'present', 'prohibit', 'exclude', 'missing', 'required'];

    /**
     * Native methods that can add arbitrary rules, presence rules included.
     *
     * @var array<string, true>
     */
    private const array UNREADABLE = ['when' => true, 'unless' => true, 'wheninput' => true];

    /**
     * @param  FieldRuleChain::BASE_*|null  $base  null for a base whose value cannot be read
     * @param  list<MethodCall>  $hops
     */
    public function read(?string $base, bool $strictInteger, array $hops, Scope $scope): ?FieldRuleChain
    {
        $effects = [];

        foreach ($hops as $hop) {
            $hopEffects = $this->effects($hop, $base, $scope);

            if ($hopEffects === null) {
                return null;
            }

            array_push($effects, ...$hopEffects);
        }

        return new FieldRuleChain(
            in_array(ModifierEffect::Opaque, $effects, true) ? null : $base,
            $strictInteger || in_array(ModifierEffect::StrictInteger, $effects, true),
            in_array(ModifierEffect::Required, $effects, true),
            in_array(ModifierEffect::Nullable, $effects, true),
            in_array(ModifierEffect::Conditional, $effects, true),
        );
    }

    /**
     * @param  FieldRuleChain::BASE_*|null  $base
     * @return list<ModifierEffect>|null
     */
    private function effects(MethodCall $hop, ?string $base, Scope $scope): ?array
    {
        $name = $this->methodName($hop);

        if ($name === null || isset(self::UNREADABLE[$name]) || ! $this->isNativeRuleMethod($hop, $name, $scope)) {
            return null;
        }

        if ($name === 'rule') {
            return $this->ruleArguments->classify($hop, $scope);
        }

        return [$this->effect($hop, $name, $base, $scope)];
    }

    /**
     * @param  FieldRuleChain::BASE_*|null  $base
     */
    private function effect(MethodCall $hop, string $name, ?string $base, Scope $scope): ModifierEffect
    {
        return match (true) {
            $name === 'required' => ModifierEffect::Required,
            $name === 'nullable' => ModifierEffect::Nullable,
            $this->isConditional($name) => ModifierEffect::Conditional,
            $name === 'integer' && $base === FieldRuleChain::BASE_NUMERIC => $this->arguments->isTrue($hop, 'strict', 0, $scope)
                ? ModifierEffect::StrictInteger
                : ModifierEffect::Constraint,
            isset(self::CONSTRAINTS[$name]) => ModifierEffect::Constraint,
            default => ModifierEffect::Opaque,
        };
    }

    /**
     * A macro is reached through `__call` and can do anything, so only methods
     * the rule class declares itself are trusted, even when an extension such
     * as Larastan types the macro.
     */
    private function isNativeRuleMethod(MethodCall $hop, string $name, Scope $scope): bool
    {
        $classReflections = $scope->getType($hop->var)->getObjectClassReflections();

        if ($classReflections === []) {
            return false;
        }

        foreach ($classReflections as $classReflection) {
            if (! $classReflection->hasNativeMethod($name)) {
                return false;
            }
        }

        return true;
    }

    private function isConditional(string $name): bool
    {
        if ($name === 'required') {
            return false;
        }

        return array_filter(self::CONDITIONAL_PREFIXES, static fn (string $prefix): bool => str_starts_with($name, $prefix)) !== [];
    }

    private function methodName(MethodCall $call): ?string
    {
        return $call->name instanceof Identifier ? $call->name->toLowerString() : null;
    }
}
