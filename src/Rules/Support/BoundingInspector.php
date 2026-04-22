<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Rules\Support;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantIntegerType;
use SanderMuller\LaravelFluentValidationPhpstan\Parser\FluentValidationChainVisitor;

final readonly class BoundingInspector
{
    /** @var list<string> */
    private array $boundingMethods;

    /** @var list<string> */
    private array $boundingRuleStringPrefixes;

    /**
     * @param  list<string>  $boundingMethods
     * @param  list<string>  $boundingRuleStringPrefixes
     */
    public function __construct(
        array $boundingMethods,
        array $boundingRuleStringPrefixes,
    ) {
        $this->boundingMethods = $this->normalize($boundingMethods);
        $this->boundingRuleStringPrefixes = $this->normalize($boundingRuleStringPrefixes);
    }

    public function chainHasBoundingMethod(MethodCall $node): bool
    {
        /** @var list<string|null> $chain */
        $chain = $node->getAttribute(FluentValidationChainVisitor::CHAIN_ATTR, []);

        foreach ($chain as $method) {
            if ($method !== null && in_array($method, $this->boundingMethods, true)) {
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
     * @return list<string>
     */
    private function normalize(array $values): array
    {
        return array_values(array_map(strtolower(...), $values));
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

        return in_array($prefix, $this->boundingRuleStringPrefixes, true);
    }
}
