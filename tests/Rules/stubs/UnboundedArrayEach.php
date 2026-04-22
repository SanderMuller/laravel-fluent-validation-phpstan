<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class UnboundedArrayEach
{
    public function plainEach(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string()->exists('users', 'id'));
    }

    public function eachWithArrayOfRules(): ArrayRule
    {
        return FluentRule::array()->each(['required', 'string']);
    }

    public function eachWithNullKeys(): ArrayRule
    {
        return FluentRule::array(null)->each(FluentRule::string());
    }

    public function eachWithEmptyKeys(): ArrayRule
    {
        return FluentRule::array([])->each(FluentRule::string());
    }

    public function eachAfterMin(): ArrayRule
    {
        return FluentRule::array()->min(1)->each(FluentRule::string());
    }

    public function eachAfterDistinct(): ArrayRule
    {
        return FluentRule::array()->distinct()->each(FluentRule::string());
    }

    public function eachAfterRequiredArrayKeys(): ArrayRule
    {
        return FluentRule::array()->requiredArrayKeys('a', 'b')->each(FluentRule::string());
    }
}
