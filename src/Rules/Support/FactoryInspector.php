<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Rules\Support;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use SanderMuller\FluentValidation\FluentRule;
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

    public function isListFactory(Node $root): bool
    {
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
}
