<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

/**
 * Static type of the `keys` arg is a union that includes null — runtime could
 * be a bounded constant array OR null (= unbounded). The rule must treat this
 * as unbounded, not bounded, because it can't prove all branches are non-empty.
 */
final class NullableKeysUnion
{
    /**
     * @param  array{a: string, b: string}|null  $keys
     */
    public function nullableShapeKeys(?array $keys): ArrayRule
    {
        return FluentRule::array($keys)->each(FluentRule::string());
    }
}
