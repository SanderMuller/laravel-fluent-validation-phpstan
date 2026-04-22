<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class BoundedArray
{
    public function maxBeforeEach(): ArrayRule
    {
        return FluentRule::array()->max(10)->each(FluentRule::string());
    }

    public function maxAfterEach(): ArrayRule
    {
        return FluentRule::array()->each(FluentRule::string())->max(10);
    }

    public function betweenBeforeEach(): ArrayRule
    {
        return FluentRule::array()->between(1, 5)->each(FluentRule::string());
    }

    public function exactlyBeforeEach(): ArrayRule
    {
        return FluentRule::array()->exactly(3)->each(FluentRule::string());
    }

    public function listWithMax(): ArrayRule
    {
        return FluentRule::list()->max(10)->each(FluentRule::string());
    }

    public function trailingMaxInAssignment(): void
    {
        $rule = FluentRule::array()->each(FluentRule::string())->max(10);

        $rule->buildNestedRules('field');
    }
}
