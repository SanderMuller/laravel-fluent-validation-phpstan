<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class UnboundedMixedCase
{
    public function mixedCaseEach(): ArrayRule
    {
        return FluentRule::array()->EaCh(FluentRule::string());
    }

    public function mixedCaseNonBoundingAndEach(): ArrayRule
    {
        return FluentRule::array()->MIN(1)->EACH(FluentRule::string());
    }
}
