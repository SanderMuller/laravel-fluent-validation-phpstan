<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class BoundedRuleEscapeHatch
{
    public function ruleStringMax(): ArrayRule
    {
        return FluentRule::array()->rule('max:10')->each(FluentRule::string());
    }

    public function ruleArrayMax(): ArrayRule
    {
        return FluentRule::array()->rule(['max', 10])->each(FluentRule::string());
    }

    public function ruleArraySingleStringMax(): ArrayRule
    {
        return FluentRule::array()->rule(['max:10'])->each(FluentRule::string());
    }

    public function ruleStringMixedCase(): ArrayRule
    {
        return FluentRule::array()->rule('MAX:10')->each(FluentRule::string());
    }

    public function ruleStringSize(): ArrayRule
    {
        return FluentRule::array()->rule('size:3')->each(FluentRule::string());
    }

    public function ruleStringBetween(): ArrayRule
    {
        return FluentRule::array()->rule('between:1,5')->each(FluentRule::string());
    }
}
