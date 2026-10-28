<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;

use function PHPStan\Testing\assertType;

final class SchemaReturnsArray extends FormRequest
{
    use HasFluentRules;

    /**
     * @return array<string, mixed>
     */
    public function schema(FluentSchema $rules): array
    {
        return [];
    }
}

function testSchemaReturnsArray(SchemaReturnsArray $request): void
{
    assertType('array<string, mixed>', $request->rules());
}
