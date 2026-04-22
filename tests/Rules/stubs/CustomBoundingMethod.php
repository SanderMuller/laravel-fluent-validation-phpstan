<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

/**
 * Uses `->contains(...)` as a placeholder for a consumer-registered macro
 * (e.g. `ArrayRule::macro('boundedBy', fn (int $n) => $this->max($n));`).
 * Default config does not treat `contains` as a bound — the chain is flagged.
 * When `boundingMethods` includes `contains`, the chain is considered bounded.
 */
final class CustomBoundingMethod
{
    public function containsThenEach(): ArrayRule
    {
        return FluentRule::array()->contains('x')->each(FluentRule::string());
    }
}
