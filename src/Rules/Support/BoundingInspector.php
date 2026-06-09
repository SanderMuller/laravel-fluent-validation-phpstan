<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Rules\Support;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantIntegerType;
use SanderMuller\LaravelFluentValidationPhpstan\Parser\FluentValidationChainVisitor;

final readonly class BoundingInspector
{
    /**
     * Hash-set form of the bounding methods list for O(1) isset lookup.
     *
     * @var array<string, true>
     */
    private array $boundingMethods;

    /**
     * Hash-set form of the bounding rule-string prefixes for O(1) isset lookup.
     *
     * @var array<string, true>
     */
    private array $boundingRuleStringPrefixes;

    /**
     * @param  list<string>  $boundingMethods
     * @param  list<string>  $boundingRuleStringPrefixes
     */
    public function __construct(
        array $boundingMethods,
        array $boundingRuleStringPrefixes,
    ) {
        $this->boundingMethods = $this->toSet($boundingMethods);
        $this->boundingRuleStringPrefixes = $this->toSet($boundingRuleStringPrefixes);
    }

    public function chainHasBoundingMethod(MethodCall $node): bool
    {
        /** @var list<string|null> $chain */
        $chain = $node->getAttribute(FluentValidationChainVisitor::CHAIN_ATTR, []);

        foreach ($chain as $method) {
            if ($method !== null && isset($this->boundingMethods[$method])) {
                return true;
            }
        }

        return false;
    }

    public function chainHasBoundingRule(MethodCall $node, Scope $scope): bool
    {
        /** @var list<Expr> $ruleArgs */
        $ruleArgs = $node->getAttribute(FluentValidationChainVisitor::RULE_ARGS_ATTR, []);

        foreach ($ruleArgs as $expr) {
            if ($this->ruleArgBounds($expr, $scope)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param  list<string>  $values
     * @return array<string, true>
     */
    private function toSet(array $values): array
    {
        /** @var array<string, true> */
        return array_fill_keys(array_map(strtolower(...), $values), true);
    }

    private function ruleArgBounds(Expr $expr, Scope $scope): bool
    {
        $type = $scope->getType($expr);

        foreach ($type->getConstantStrings() as $constantString) {
            if ($this->ruleStringBounds($constantString->getValue())) {
                return true;
            }
        }

        foreach ($type->getConstantArrays() as $constantArray) {
            $first = $constantArray->getOffsetValueType(new ConstantIntegerType(0));
            foreach ($first->getConstantStrings() as $constantString) {
                // Array-form rules ship as either a tuple `[name, ...params]` or a
                // single-element `[full_rule_string]`. `HasFieldModifiers::rule()`
                // collapses both to `"name:params"`. Reuse `ruleStringBounds` so the
                // leading name is checked the same way the string form is — this
                // catches `rule(['max:10'])` as a valid bound, not just `rule(['max', 10])`.
                if ($this->ruleStringBounds($constantString->getValue())) {
                    return true;
                }
            }
        }

        return false;
    }

    private function ruleStringBounds(string $raw): bool
    {
        $needle = strstr($raw, ':', true);
        $prefix = strtolower($needle === false ? $raw : $needle);

        return isset($this->boundingRuleStringPrefixes[$prefix]);
    }
}
