<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\HasFluentRules;

use function PHPStan\Testing\assertType;

final class UnrelatedSchema extends FormRequest
{
    use HasFluentRules;

    /**
     * A coincidental, unrelated schema() — the extension must not hijack it.
     *
     * @return array<string, string>
     */
    public function schema(string $table): array
    {
        return [];
    }
}

function testUnrelatedSchema(UnrelatedSchema $request): void
{
    assertType('array{}', $request->rules());
}
