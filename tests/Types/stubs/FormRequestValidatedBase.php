<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;

/**
 * Declares `schema()` in its own file, so a final child resolves it from a
 * different file than the call site.
 */
abstract class FormRequestValidatedBase extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return ['title' => $rules->string()->required()];
    }
}
