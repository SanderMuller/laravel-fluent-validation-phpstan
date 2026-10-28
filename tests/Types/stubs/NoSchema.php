<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\HasFluentRules;

use function PHPStan\Testing\assertType;

final class NoSchema extends FormRequest
{
    use HasFluentRules;
}

function testNoSchema(NoSchema $request): void
{
    assertType('array{}', $request->rules());
}
