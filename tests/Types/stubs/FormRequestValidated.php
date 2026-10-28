<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\Rules\StringRule;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

final class SchemaValidatedRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return [
            'name' => $rules->string()->required(),
            'age' => FluentRule::integer(),
            'role' => FluentRule::enum(RuleSetFromRole::class)->required(),
        ];
    }

    public function handle(): void
    {
        assertType('array{name: non-empty-string, age?: float|int|string, role: mixed}', $this->validated());
    }
}

function schemaValidated(SchemaValidatedRequest $request, \Closure $closure): void
{
    assertType('array{name: non-empty-string, age?: float|int|string, role: mixed}', $request->validated());
    assertType('array{name: non-empty-string, age?: float|int|string, role: mixed}', $request->validated(null));
    assertType('non-empty-string', $request->validated('name'));
    assertType('float|int|string|null', $request->validated('age'));
    assertType('float|int|string|false', $request->validated('age', false));
    assertType('float|int|string|false', $request->validated(key: 'age', default: false));
    assertType("'fallback'", $request->validated('missing', 'fallback'));
    assertType('null', $request->validated('missing'));
    assertType('mixed', $request->validated('age.nested'));
    assertType('mixed', $request->validated('age', $closure));
}

final class RulesValidatedRequest extends FormRequest
{
    use HasFluentRules;

    public function rules(): array
    {
        return ['email' => FluentRule::string()->required()->email()];
    }
}

final class RuleSetSchemaRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['count' => $rules->integer(strict: true)->required()]);
    }
}

final class InheritedSchemaRequest extends FormRequestValidatedBase {}

final class PrepareForValidationRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return ['slug' => $rules->string()->required()];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['slug' => 'x']);
    }
}

final class NoSchemaRequest extends FormRequest
{
    use HasFluentRules;
}

function resolvedRequests(
    RulesValidatedRequest $rules,
    RuleSetSchemaRequest $ruleSet,
    InheritedSchemaRequest $inherited,
    PrepareForValidationRequest $prepared,
    NoSchemaRequest $noSchema,
): void {
    assertType('array{email: non-empty-string}', $rules->validated());
    assertType('array{count: int}', $ruleSet->validated());
    assertType('array{title: non-empty-string}', $inherited->validated());
    assertType('array{slug: non-empty-string}', $prepared->validated());
    assertType('array{}', $noSchema->validated());
}

final class PassedValidationRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return ['name' => $rules->string()->required()];
    }

    protected function passedValidation(): void
    {
        $this->replace(['name' => 1]);
    }
}

final class ValidatorOverrideRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return ['name' => $rules->string()->required()];
    }

    public function validator(Factory $factory): Validator
    {
        return $factory->make([], []);
    }
}

final class ParentRulesMergeRequest extends FormRequestValidatedBase
{
    public function rules(): array
    {
        return [...parent::rules(), 'body' => FluentRule::string()->required()];
    }
}

/**
 * The trait merges `rules()` over `schema()`, so neither body alone is the shape.
 */
final class RulesAndSchemaRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return ['name' => $rules->string()->required()];
    }

    public function rules(): array
    {
        return ['body' => FluentRule::string()->required()];
    }
}

final class MultiStatementRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        $name = $rules->string()->required();

        return ['name' => $name];
    }
}

class NonFinalRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return ['name' => $rules->string()->required()];
    }
}

final class PlainRequest extends FormRequest
{
    public function rules(): array
    {
        return ['name' => FluentRule::string()->required()];
    }
}

final class ThisDependentRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return [
            'name' => $rules->string()->required(),
            'dynamic' => $this->dynamicRule(),
        ];
    }

    private function dynamicRule(): StringRule
    {
        return FluentRule::string()->required();
    }
}

function fallbackRequests(
    PassedValidationRequest $passed,
    ValidatorOverrideRequest $validator,
    ParentRulesMergeRequest $merged,
    RulesAndSchemaRequest $both,
    MultiStatementRequest $multi,
    NonFinalRequest $nonFinal,
    PlainRequest $plain,
    ThisDependentRequest $thisDependent,
): void {
    assertType('mixed', $passed->validated());
    assertType('mixed', $validator->validated());
    assertType('mixed', $merged->validated());
    assertType('mixed', $both->validated());
    assertType('mixed', $multi->validated());
    assertType('mixed', $nonFinal->validated());
    assertType('mixed', $plain->validated());
    assertType('array{name: non-empty-string, dynamic?: mixed}', $thisDependent->validated());
}
