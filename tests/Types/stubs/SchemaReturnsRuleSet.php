<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

final class SchemaReturnsRuleSet extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['name' => $rules->string()->required()]);
    }
}

function testSchemaReturnsRuleSet(SchemaReturnsRuleSet $request): void
{
    assertType(RuleSet::class, $request->rules());
}
