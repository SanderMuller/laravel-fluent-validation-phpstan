<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Rules\Support;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;

final readonly class KeysInspector
{
    public function __construct(
        private FactoryInspector $factoryInspector,
    ) {}

    public function keysAreBounded(Node $root, Scope $scope): bool
    {
        if ($this->factoryInspector->isListFactory($root)) {
            return false;
        }

        $keysArg = $this->resolveKeysArgument($root);
        if (! $keysArg instanceof Arg) {
            return false;
        }

        $type = $scope->getType($keysArg->value);

        // A union that carries any non-constant-array member (e.g. `array{a:string}|null`,
        // `list<string>|array{a:string}`) can resolve to the non-array branch at runtime.
        // Only treat the chain as bounded when *every* possible runtime value is a
        // non-empty constant array.
        if (! $type->isConstantArray()->yes()) {
            return false;
        }

        $constantArrays = $type->getConstantArrays();
        if ($constantArrays === []) {
            return false;
        }

        foreach ($constantArrays as $constantArray) {
            if (count($constantArray->getKeyTypes()) === 0) {
                return false;
            }
        }

        return true;
    }

    private function resolveKeysArgument(Node $root): ?Arg
    {
        $args = $this->factoryArgs($root);

        foreach ($args as $arg) {
            if ($arg instanceof Arg && $arg->name instanceof Identifier && $arg->name->toString() === 'keys') {
                return $arg;
            }
        }

        $first = $args[0] ?? null;
        if ($first instanceof Arg && ! $first->name instanceof Identifier) {
            return $first;
        }

        return null;
    }

    /** @return array<Arg|Node\VariadicPlaceholder> */
    private function factoryArgs(Node $root): array
    {
        if ($root instanceof StaticCall) {
            return $root->args;
        }

        if ($root instanceof New_) {
            return $root->args;
        }

        return [];
    }
}
