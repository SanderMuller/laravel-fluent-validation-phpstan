<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;

/**
 * Reads a boolean flag such as `strict` off a rule-chain call, whether it is
 * passed by name or by position.
 */
final readonly class CallArguments
{
    /**
     * Whether the flag is certainly `true`. Anything less certain reads as
     * false, which for `strict` is the wider of the two types.
     */
    public function isTrue(StaticCall|MethodCall $call, string $name, int $position, Scope $scope): bool
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
