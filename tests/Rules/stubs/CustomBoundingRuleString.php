<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\Rules\ArrayRule;

/**
 * Uses `rule('in:...')` as a rule-string form not recognized by default.
 * Default config does not treat `in:` as a bounding prefix — the chain is flagged.
 * When `boundingRuleStringPrefixes` includes `in`, the chain is considered bounded.
 */
final class CustomBoundingRuleString
{
    public function ruleInThenEach(): ArrayRule
    {
        return FluentRule::array()->rule('in:a,b,c')->each(FluentRule::string());
    }
}
