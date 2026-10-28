<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;

/**
 * Reads an argument off a rule-chain call, whether it is passed by name or by
 * position.
 */
final readonly class CallArguments
{
    /**
     * Whether the flag is certainly `true`. Anything less certain reads as
     * false, which for `strict` is the wider of the two types.
     */
    public function isTrue(StaticCall|MethodCall $call, string $name, int $position, Scope $scope): bool
    {
        $value = $this->value($call, $name, $position);

        return $value instanceof Expr && $scope->getType($value)->isTrue()->yes();
    }

    public function value(StaticCall|MethodCall $call, string $name, int $position): ?Expr
    {
        if ($call->isFirstClassCallable()) {
            return null;
        }

        foreach ($call->getArgs() as $index => $arg) {
            if ($this->argMatches($arg, $index, $name, $position)) {
                return $arg->value;
            }
        }

        return null;
    }

    private function argMatches(Arg $arg, int $index, string $name, int $position): bool
    {
        if ($arg->name instanceof Identifier) {
            return $arg->name->toString() === $name;
        }

        return ! $arg->unpack && $index === $position;
    }
}
