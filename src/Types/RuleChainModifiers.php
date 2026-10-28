<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
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
     * `validated()`. `required()` itself is matched before these, so the
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

            if ($name === 'required') {
                $required = true;
            } elseif ($name === 'nullable') {
                $nullable = true;
            } elseif ($name === 'integer' && $base === FieldRuleChain::BASE_NUMERIC) {
                $strictInteger = $strictInteger || $this->argIsTrue($hop, 'strict', 0, $scope);
            } elseif ($name !== null && $this->isConditional($name)) {
                $conditional = true;
            } elseif ($name === null || ! isset(self::CONSTRAINTS[$name])) {
                return null;
            }
        }

        return new FieldRuleChain($base, $strictInteger, $required, $nullable, $conditional);
    }

    private function isConditional(string $name): bool
    {
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

    /**
     * Whether the `strict` flag is certainly `true`. Anything less certain reads
     * as non-strict, whose type is the wider of the two.
     */
    public function argIsTrue(StaticCall|MethodCall $call, string $name, int $position, Scope $scope): bool
    {
        if ($call->isFirstClassCallable()) {
            return false;
        }

        foreach ($call->getArgs() as $index => $arg) {
            if ($this->argMatches($arg, $index, $name, $position)) {
                return $scope->getType($arg->value)->isTrue()->yes();
            }
        }

        return false;
    }

    private function argMatches(Arg $arg, int $index, string $name, int $position): bool
    {
        if ($arg->name instanceof Identifier) {
            return $arg->name->toString() === $name;
        }

        return ! $arg->unpack && $index === $position;
    }
}
