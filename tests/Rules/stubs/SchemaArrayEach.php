<?php declare(strict_types=1);

namespace App;

use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\Rules\ArrayRule;

final class SchemaArrayEach
{
    public function unboundedArray(FluentSchema $rules): ArrayRule
    {
        return $rules->array()->each($rules->string());
    }

    public function unboundedList(FluentSchema $rules): ArrayRule
    {
        return $rules->list()->each($rules->string());
    }

    public function boundedByMax(FluentSchema $rules): ArrayRule
    {
        return $rules->array()->max(10)->each($rules->string());
    }

    public function boundedByKeys(FluentSchema $rules): ArrayRule
    {
        return $rules->array(['name', 'email'])->each($rules->string());
    }

    public function unboundedListIgnoresKeys(FluentSchema $rules): ArrayRule
    {
        return $rules->list()->min(1)->each($rules->string());
    }

    public function otherReceiverIsIgnored(OtherRuleFactory $factory): ArrayRule
    {
        return $factory->array()->each($factory->array());
    }
}

final class OtherRuleFactory
{
    public function array(): ArrayRule
    {
        return new ArrayRule(['id']);
    }
}
