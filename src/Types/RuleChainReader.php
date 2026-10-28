<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\LaravelFluentValidationPhpstan\Rules\Support\FactoryInspector;

/**
 * Reads a literal `FluentRule::<base>()->modifier()->...` chain (or the same
 * chain off an injected {@see FluentSchema}) into a {@see FieldRuleChain}, or
 * null when the chain cannot be read.
 */
final readonly class RuleChainReader
{
    /** @var array<string, FieldRuleChain::BASE_*> */
    private const array BASES = [
        'string' => FieldRuleChain::BASE_STRING,
        'numeric' => FieldRuleChain::BASE_NUMERIC,
        'integer' => FieldRuleChain::BASE_NUMERIC,
        'boolean' => FieldRuleChain::BASE_BOOLEAN,
    ];

    public function __construct(
        private FactoryInspector $factoryInspector,
        private RuleChainModifiers $modifiers,
    ) {}

    public function read(Expr $expr, Scope $scope): ?FieldRuleChain
    {
        $hops = [];

        /**
         * A first-class callable such as `FluentRule::string(...)` is a Closure
         * rule at runtime, which lets any value through.
         */
        while ($expr instanceof MethodCall) {
            if ($expr->isFirstClassCallable()) {
                return null;
            }

            $hops[] = $expr;
            $expr = $expr->var;
        }

        $baseCall = $this->baseCall($expr, $hops, $scope);

        if ($baseCall === null || $baseCall->isFirstClassCallable()) {
            return null;
        }

        $baseName = $this->methodName($baseCall);

        if ($baseName === null || ! isset(self::BASES[$baseName])) {
            return null;
        }

        return $this->modifiers->read(
            self::BASES[$baseName],
            $baseName === 'integer' && $this->modifiers->argIsTrue($baseCall, 'strict', 2, $scope),
            $hops,
            $scope,
        );
    }

    /**
     * The call that picks the base rule: the `FluentRule::` static root, or the
     * innermost hop when the root is a {@see FluentSchema} instance. Takes the
     * hops by reference so the schema hop is not read again as a modifier.
     *
     * @param  list<MethodCall>  $hops  outermost first
     */
    private function baseCall(Expr $root, array &$hops, Scope $scope): StaticCall|MethodCall|null
    {
        if ($root instanceof StaticCall) {
            return $this->factoryInspector->classNameIs($root->class, FluentRule::class) ? $root : null;
        }

        if ($hops === [] || ! (new ObjectType(FluentSchema::class))->isSuperTypeOf($scope->getType($root))->yes()) {
            return null;
        }

        return array_pop($hops);
    }

    private function methodName(StaticCall|MethodCall $call): ?string
    {
        return $call->name instanceof Identifier ? $call->name->toLowerString() : null;
    }
}
