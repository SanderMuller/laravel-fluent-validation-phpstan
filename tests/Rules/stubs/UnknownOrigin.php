<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class UnknownOrigin
{
    public function __construct(
        private ArrayRule $builder,
    ) {}

    public function fromProperty(): ArrayRule
    {
        return $this->builder->each(FluentRule::string());
    }

    public function fromMethodReturn(): ArrayRule
    {
        return $this->makeBuilder()->each(FluentRule::string());
    }

    private function makeBuilder(): ArrayRule
    {
        return FluentRule::array();
    }
}
