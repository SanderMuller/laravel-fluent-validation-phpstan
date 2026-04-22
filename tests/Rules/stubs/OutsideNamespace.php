<?php declare(strict_types=1);

namespace Vendor\SomePackage;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class OutsideNamespace
{
    public function plainEach(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string());
    }
}
