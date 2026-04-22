<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class DynamicKeys
{
    /**
     * @param  list<string>  $keys
     */
    public function dynamicKeysNoMax(array $keys): ArrayRule
    {
        return FluentRule::array($keys)->each(FluentRule::string());
    }

    /**
     * @param  list<string>  $keys
     */
    public function dynamicKeysWithMax(array $keys): ArrayRule
    {
        return FluentRule::array($keys)->max(10)->each(FluentRule::string());
    }
}
