<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

/**
 * The runtime gate reads `ReflectionNamedType::getName()`, which reports
 * `FluentSchema` for `?FluentSchema` — so the trait accepts this shape and the
 * extension has to accept it too.
 */
final class NullableSchemaParameter extends FormRequest
{
    use HasFluentRules;

    public function schema(?FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['name' => $rules?->string()->required()]);
    }
}

function testNullableSchemaParameter(NullableSchemaParameter $request): void
{
    assertType(RuleSet::class, $request->rules());
}
