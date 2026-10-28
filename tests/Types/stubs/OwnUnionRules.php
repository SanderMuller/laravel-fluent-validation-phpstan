<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

/**
 * A consumer may declare the trait's own signature by hand. That method returns
 * whatever they wrote, not `schema()`'s value, so it must be left alone even
 * though its return type is shaped exactly like the trait's fallback.
 */
final class OwnUnionRules extends FormRequest
{
    use HasFluentRules;

    /**
     * @return array<string, mixed>|RuleSet
     */
    public function rules(): array|RuleSet
    {
        return [];
    }

    public function schema(FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['name' => $rules->string()->required()]);
    }
}

function testOwnUnionRules(OwnUnionRules $request): void
{
    assertType('array<string, mixed>|' . RuleSet::class, $request->rules());
}
