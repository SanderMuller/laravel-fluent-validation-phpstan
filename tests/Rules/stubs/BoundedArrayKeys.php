<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

enum UserKey: string
{
    case Email = 'email';
    case Name = 'name';
}

final class BoundedArrayKeys
{
    public function positionalKeys(): ArrayRule
    {
        return FluentRule::array(['a', 'b'])->each(FluentRule::string());
    }

    public function namedKeys(): ArrayRule
    {
        return FluentRule::array(keys: ['a', 'b'])->each(FluentRule::string());
    }

    public function enumCasesKeys(): ArrayRule
    {
        return FluentRule::array(UserKey::cases())->each(FluentRule::string());
    }
}
