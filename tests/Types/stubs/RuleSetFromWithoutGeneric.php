<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

/**
 * Against a `RuleSet` that declares no template, the extension stays out of the
 * way rather than inventing a generic the class does not have.
 */
function ruleSetFromWithoutGeneric(): void
{
    assertType(RuleSet::class, RuleSet::from(['name' => FluentRule::string()->required()]));
}
