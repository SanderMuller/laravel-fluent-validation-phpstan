<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

abstract class BaseSchemaRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['video_id' => $rules->string()->required()]);
    }
}

final class InheritedSchema extends BaseSchemaRequest {}

function testInheritedSchema(InheritedSchema $request): void
{
    assertType(RuleSet::class, $request->rules());
    assertType(RuleSet::class, $request->rules()->merge([]));
}
