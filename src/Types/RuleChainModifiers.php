<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;

/**
 * Classifies the modifier hops of a rule chain for {@see RuleChainReader}.
 *
 * Every rule a chain adds can only narrow the value it lets through, except the
 * presence modifiers that skip or drop the key. Modifiers are therefore matched
 * against an allowlist: a known constraint keeps the base type, a presence
 * modifier makes the key optional, and anything else (`rule()`, `whenInput()`,
 * `when()`, a macro, a dynamic name) makes the whole chain unreadable, because
 * it could add `nullable` or `exclude` behind the analyser's back.
 */
final readonly class RuleChainModifiers
{
    public function __construct(private CallArguments $arguments) {}

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
     * @param  FieldRuleChain::BASE_*  $base
     * @param  list<MethodCall>  $hops
     */
    public function read(string $base, bool $strictInteger, array $hops, Scope $scope): ?FieldRuleChain
    {
        $required = false;
        $nullable = false;
        $conditional = false;

        foreach ($hops as $hop) {
            $name = $this->methodName($hop);

            if ($name === null || ! $this->isKnown($name, $base)) {
                return null;
            }

            $required = $required || $name === 'required';
            $nullable = $nullable || $name === 'nullable';
            $conditional = $conditional || $this->isConditional($name);
            $strictInteger = $strictInteger || ($name === 'integer' && $this->arguments->isTrue($hop, 'strict', 0, $scope));
        }

        return new FieldRuleChain($base, $strictInteger, $required, $nullable, $conditional);
    }

    /**
     * @param  FieldRuleChain::BASE_*  $base
     */
    private function isKnown(string $name, string $base): bool
    {
        if ($name === 'integer') {
            return $base === FieldRuleChain::BASE_NUMERIC;
        }

        return $name === 'required' || $name === 'nullable' || isset(self::CONSTRAINTS[$name]) || $this->isConditional($name);
    }

    private function isConditional(string $name): bool
    {
        if ($name === 'required') {
            return false;
        }

        foreach (self::CONDITIONAL_PREFIXES as $prefix) {
            if (str_starts_with($name, $prefix)) {
                return true;
            }
        }

        return false;
    }

    private function methodName(MethodCall $call): ?string
    {
        return $call->name instanceof Identifier ? $call->name->toLowerString() : null;
    }
}
