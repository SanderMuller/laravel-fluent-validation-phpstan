<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class UnboundedListEach
{
    public function plainListEach(): ArrayRule
    {
        return FluentRule::list()->each(FluentRule::string());
    }

    public function listWithMinOnly(): ArrayRule
    {
        return FluentRule::list()->min(5)->each(FluentRule::string());
    }
}
