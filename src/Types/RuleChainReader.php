<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use SanderMuller\FluentValidation\Contracts\FluentRuleContract;
use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\LaravelFluentValidationPhpstan\Rules\Support\FactoryInspector;

/**
 * Reads a literal `FluentRule::<base>()->modifier()->...` chain (or the same
 * chain off an injected {@see FluentSchema}) into a {@see FieldRuleChain}, or
 * null when the chain cannot be read. A base outside {@see self::BASES} still
 * reads, with a `mixed` value, so `required()` keeps its key present.
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
        private CallArguments $arguments,
    ) {}

    public function read(Expr $expr, Scope $scope): ?FieldRuleChain
    {
        $hops = [];
        $chain = $expr;

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

        /**
         * A static macro is reached through `__callStatic` and types as
         * `mixed`, and a chain ending in `->toArray()` or `->getLabel()` is no
         * rule at all; both are rejected here.
         */
        if (! $this->isRule($scope->getType($baseCall)) || ! $this->isRule($scope->getType($chain))) {
            return null;
        }

        $baseName = $this->methodName($baseCall);

        return $this->modifiers->read(
            $baseName === null ? null : self::BASES[$baseName] ?? null,
            $baseName === 'integer' && $this->arguments->isTrue($baseCall, 'strict', 2, $scope),
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

    private function isRule(Type $type): bool
    {
        return (new ObjectType(FluentRuleContract::class))->isSuperTypeOf($type)->yes();
    }

    private function methodName(StaticCall|MethodCall $call): ?string
    {
        return $call->name instanceof Identifier ? $call->name->toLowerString() : null;
    }
}
