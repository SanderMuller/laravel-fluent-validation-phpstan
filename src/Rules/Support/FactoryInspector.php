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

    public function isRecognizedFactory(Node $root): bool
    {
        if ($root instanceof New_) {
            return $this->classNameIs($root->class, self::ARRAY_RULE_CLASS);
        }

        if ($root instanceof StaticCall) {
            return $this->classNameIs($root->class, self::FLUENT_RULE_CLASS)
                && $this->staticCallNameIn($root, ['array', 'list']);
        }

        return false;
    }

    public function isListFactory(Node $root): bool
    {
        return $root instanceof StaticCall
            && $this->classNameIs($root->class, self::FLUENT_RULE_CLASS)
            && $this->staticCallNameIn($root, ['list']);
    }

    public function classNameIs(Node $class, string $fqn): bool
    {
        return $class instanceof Name && $class->toString() === $fqn;
    }

    /** @param  list<string>  $names */
    public function staticCallNameIn(StaticCall $call, array $names): bool
    {
        if (! $call->name instanceof Identifier) {
            return false;
        }

        return in_array(strtolower($call->name->toString()), $names, true);
    }
}
