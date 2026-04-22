<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\Rules\ArrayRule;

final class NewArrayRuleDirect
{
    public function unbounded(): ArrayRule
    {
        return (new ArrayRule())->each(['required', 'string']);
    }

    public function bounded(): ArrayRule
    {
        return (new ArrayRule(['a', 'b']))->each(['required', 'string']);
    }
}
