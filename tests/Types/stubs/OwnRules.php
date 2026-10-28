<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

final class OwnRules extends FormRequest
{
    use HasFluentRules;

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }

    public function schema(FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['name' => $rules->string()->required()]);
    }
}

function testOwnRules(OwnRules $request): void
{
    assertType('array<string, mixed>', $request->rules());
}
