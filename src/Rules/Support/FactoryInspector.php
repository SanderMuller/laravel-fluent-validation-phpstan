<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Rules\Support;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Type\ObjectType;
use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final readonly class FactoryInspector
{
    /** @var class-string<ArrayRule> */
    private const ARRAY_RULE_CLASS = ArrayRule::class;

    /** @var class-string<FluentRule> */
    private const FLUENT_RULE_CLASS = FluentRule::class;

    /** @var array<string, true> */
    private const ARRAY_FACTORIES = ['array' => true, 'list' => true];

    /** @var array<string, true> */
    private const LIST_FACTORIES = ['list' => true];

    /**
     * Returns true when the AST node is a literal FluentRule factory call or a
     * direct `new ArrayRule(...)` instantiation.
     *
     * Intentionally AST-only: indirect construction (factory methods, helper
     * functions, variables holding a pre-built instance) is out of scope. This
     * is a deliberate trade-off — full type-inference coverage costs a
     * `$scope->getType()` call on every `each()` hop in the file.
     */
    public function isRecognizedFactory(Node $root): bool
    {
        if ($root instanceof New_) {
            return $this->classNameIs($root->class, self::ARRAY_RULE_CLASS);
        }

        if ($root instanceof StaticCall) {
            return $this->classNameIs($root->class, self::FLUENT_RULE_CLASS)
                && $this->staticCallNameIn($root, self::ARRAY_FACTORIES);
        }

        return false;
    }

    /**
     * Returns true when `$seed` is `array()` or `list()` called on a
     * {@see FluentSchema} builder, the `$rules->array()` form of a
     * `schema(FluentSchema $rules)` method. The receiver type is resolved only
     * after the method name matches, so other calls cost no type inference.
     */
    public function isSchemaArrayFactory(MethodCall $seed, Scope $scope): bool
    {
        return $this->methodCallNameIn($seed, self::ARRAY_FACTORIES)
            && (new ObjectType(FluentSchema::class))->isSuperTypeOf($scope->getType($seed->var))->yes();
    }

    /**
     * True for a `FluentRule::list()` root, or for a `list()` seed that
     * {@see isSchemaArrayFactory()} already matched.
     */
    public function isListFactory(Node $root): bool
    {
        if ($root instanceof MethodCall) {
            return $this->methodCallNameIn($root, self::LIST_FACTORIES);
        }

        return $root instanceof StaticCall
            && $this->classNameIs($root->class, self::FLUENT_RULE_CLASS)
            && $this->staticCallNameIn($root, self::LIST_FACTORIES);
    }

    public function classNameIs(Node $class, string $fqn): bool
    {
        return $class instanceof Name && $class->toString() === $fqn;
    }

    /** @param  array<string, true>  $names */
    public function staticCallNameIn(StaticCall $call, array $names): bool
    {
        if (! $call->name instanceof Identifier) {
            return false;
        }

        return isset($names[$call->name->toLowerString()]);
    }

    /** @param  array<string, true>  $names */
    private function methodCallNameIn(MethodCall $call, array $names): bool
    {
        return $call->name instanceof Identifier && isset($names[$call->name->toLowerString()]);
    }
}
