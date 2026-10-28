<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use SanderMuller\FluentValidation\FluentRule;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\Rules\FieldRule;
use SanderMuller\FluentValidation\Rules\StringRule;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

/**
 * @param  array<string, mixed>  $data
 */
function ruleSetFromBases(array $data): void
{
    $validated = RuleSet::from([
        'name' => FluentRule::string()->required(),
        'count' => FluentRule::integer()->required(),
        'amount' => FluentRule::numeric()->required(),
        'active' => FluentRule::boolean()->required(),
        'id' => FluentRule::integer(strict: true)->required(),
        'size' => FluentRule::numeric()->integer(strict: true)->required(),
    ])->validate($data);

    assertType("array{name: non-empty-string, count: float|int|numeric-string, amount: float|int|numeric-string, active: 0|1|'0'|'1'|bool, id: int, size: int}", $validated);
}

/**
 * Without `required()` a blank string skips every non-implicit rule, so each
 * optional key also admits `string`.
 *
 * @param  array<string, mixed>  $data
 */
function ruleSetFromOptionalKeys(array $data): void
{
    $validated = RuleSet::from([
        'name' => FluentRule::string()->max(255),
        'count' => FluentRule::integer(),
        'active' => FluentRule::boolean(),
        'id' => FluentRule::integer(strict: true),
    ])->validate($data);

    assertType('array{name?: string, count?: float|int|string, active?: 0|1|bool|string, id?: int|string}', $validated);
}

/**
 * @param  array<string, mixed>  $data
 */
function ruleSetFromNullable(array $data): void
{
    $validated = RuleSet::from([
        'optional' => FluentRule::string()->nullable(),
        'required' => FluentRule::integer()->nullable()->required(),
    ])->check($data)->validated();

    assertType('array{optional?: string|null, required: float|int|numeric-string}', $validated);
}

/**
 * A conditional presence modifier makes the key optional even next to
 * `required()`, but `required()` still rejects blank strings whenever it runs.
 *
 * @param  array<string, mixed>  $data
 */
function ruleSetFromConditional(array $data): void
{
    $validated = RuleSet::from([
        'sometimes' => FluentRule::integer()->required()->sometimes(),
        'excluded' => FluentRule::string()->required()->excludeIf('type', 'x'),
        'requiredIf' => FluentRule::string()->requiredIf('type', 'x'),
    ])->validate($data);

    assertType('array{sometimes?: float|int|numeric-string, excluded?: non-empty-string, requiredIf?: string}', $validated);
}

/**
 * @param  array<string, mixed>  $data
 */
function ruleSetFromUnreadable(array $data, StringRuleHolder $holder): void
{
    $validated = RuleSet::from([
        'raw' => FluentRule::string()->required()->rule('nullable'),
        'date' => FluentRule::date()->required(),
        'variable' => $holder->rule,
        'pipe' => 'required|string',
        'closure' => FluentRule::string(...),
        'closureHop' => FluentRule::string()->required(...),
        'name' => FluentRule::string()->required(),
    ])->validate($data);

    assertType('array{raw: non-empty-string, date: mixed, variable?: mixed, pipe?: mixed, closure?: mixed, closureHop?: mixed, name: non-empty-string}', $validated);
}

/**
 * @param  array<string, mixed>  $data
 */
function ruleSetFromSchemaBuilder(array $data, FluentSchema $rules): void
{
    $validated = RuleSet::from([
        'name' => $rules->string()->required(),
        'count' => $rules->integer(strict: true)->required(),
    ])->validate($data);

    assertType('array{name: non-empty-string, count: int}', $validated);
}

/**
 * `required()` keeps a key present even when its value cannot be read, and a
 * `rule()` that only adds a constraint keeps both presence and type.
 *
 * @param  array<string, mixed>  $data
 */
function ruleSetFromRequiredPresence(array $data): void
{
    $validated = RuleSet::from([
        'role' => FluentRule::enum(RuleSetFromRole::class)->required(),
        'password' => FluentRule::string()->required()->notIn(['secret'])->rule(Password::default())->confirmed(),
        'closure' => FluentRule::string()->required()->rule(static fn (string $attribute, mixed $value, \Closure $fail): null => null),
        'stringRule' => FluentRule::string()->required()->rule('max:255|alpha'),
        'arrayRule' => FluentRule::integer()->required()->rule(['max', 10]),
        'nativeHop' => FluentRule::string()->required()->dump(),
        'ruleRequired' => FluentRule::integer()->rule('required'),
        'ruleNullable' => FluentRule::string()->rule('nullable'),
    ])->validate($data);

    assertType('array{role: mixed, password: non-empty-string, closure: non-empty-string, stringRule: non-empty-string, arrayRule: float|int|numeric-string, nativeHop: mixed, ruleRequired: float|int|numeric-string, ruleNullable?: string|null}', $validated);
}

/**
 * A presence rule passed through `rule()` can drop the key, and a rule that
 * expands into arbitrary rules hides it entirely.
 *
 * @param  array<string, mixed>  $data
 */
function ruleSetFromPresenceRules(array $data, bool $flag): void
{
    $validated = RuleSet::from([
        'excludeIf' => FluentRule::string()->required()->rule(Rule::excludeIf($flag)),
        'requiredIf' => FluentRule::string()->rule(Rule::requiredIf($flag)),
        'sometimes' => FluentRule::string()->required()->rule('sometimes'),
        'excludeString' => FluentRule::string()->required()->rule('max:5|exclude_if:type,x'),
        'when' => FluentRule::string()->required()->rule(Rule::when($flag, ['nullable'])),
        'whenHop' => FluentRule::string()->required()->when($flag, static fn (StringRule $rule): StringRule => $rule->nullable()),
        'unknownBaseWhen' => FluentRule::enum(RuleSetFromRole::class)->required()->when($flag, static fn (FieldRule $rule): FieldRule => $rule->sometimes()),
        'dynamicRule' => FluentRule::string()->required()->rule($flag ? 'nullable' : 'max:5'),
        'macro' => FluentRule::string()->someMacro()->required(),
        'typedMacro' => FluentRule::string()->required()->typedMacro(),
    ])->validate($data);

    assertType('array{excludeIf?: non-empty-string, requiredIf?: string, sometimes?: non-empty-string, excludeString?: non-empty-string, when?: mixed, whenHop?: mixed, unknownBaseWhen?: mixed, dynamicRule?: mixed, macro?: mixed, typedMacro?: mixed}', $validated);
}

enum RuleSetFromRole: string
{
    case Owner = 'owner';
}

function ruleSetFromKeepsShapeThroughModifiers(): void
{
    $ruleSet = RuleSet::from(['name' => FluentRule::string()->required()])->failOnUnknownFields();

    assertType('SanderMuller\FluentValidation\RuleSet<array{name: non-empty-string}>', $ruleSet);
}

/**
 * @param  array<string, mixed>  $data
 * @param  array<string, mixed>  $rules
 */
function ruleSetFromFallsBackToDefault(array $data, array $rules, string $key): void
{
    assertType('array<string, mixed>', RuleSet::from(['user.name' => FluentRule::string()->required()])->validate($data));
    assertType('array<string, mixed>', RuleSet::from(['items.*' => FluentRule::string()->required()])->validate($data));
    assertType('array<string, mixed>', RuleSet::from(['12' => FluentRule::string()->required()])->validate($data));
    assertType('array<string, mixed>', RuleSet::from([$key => FluentRule::string()->required()])->validate($data));
    assertType('array<string, mixed>', RuleSet::from([...$rules, 'name' => FluentRule::string()])->validate($data));
    assertType('array<string, mixed>', RuleSet::from($rules)->validate($data));
}

final class StringRuleHolder
{
    public StringRule $rule;
}
