# Fluent-Validation PHPStan rules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sandermuller/laravel-fluent-validation-phpstan.svg?style=flat-square)](https://packagist.org/packages/sandermuller/laravel-fluent-validation-phpstan)
[![Tests](https://img.shields.io/github/actions/workflow/status/sandermuller/laravel-fluent-validation-phpstan/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sandermuller/laravel-fluent-validation-phpstan/actions/workflows/run-tests.yml)
[![PHPStan](https://img.shields.io/github/actions/workflow/status/sandermuller/laravel-fluent-validation-phpstan/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/sandermuller/laravel-fluent-validation-phpstan/actions/workflows/phpstan.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/sandermuller/laravel-fluent-validation-phpstan.svg?style=flat-square)](https://packagist.org/packages/sandermuller/laravel-fluent-validation-phpstan)
[![License](https://img.shields.io/packagist/l/sandermuller/laravel-fluent-validation-phpstan.svg?style=flat-square)](LICENSE)

PHPStan rules that flag misuse of [`sandermuller/laravel-fluent-validation`](https://github.com/sandermuller/laravel-fluent-validation) in consumer projects.

## Requirements

- PHP 8.3 or higher
- PHPStan 2.1 or higher
- `sandermuller/laravel-fluent-validation` (any version that ships `FluentRule::array()`, `FluentRule::list()`, and `ArrayRule::each/max/between/exactly/rule` — `^1.19` and up)

## Compatibility

| `laravel-fluent-validation-phpstan` | `sandermuller/laravel-fluent-validation` |
|---|---|
| `^0.1` | `^1.19` |
| `^0.4` | `^1.19`, and `^1.36` for the [`RuleSet::from()` validated shape](#rulesetfrom-validated-shape) |

## Installation

```bash
composer require --dev sandermuller/laravel-fluent-validation-phpstan
```

With [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer) the rules auto-register. Otherwise include the extension in your `phpstan.neon`:

```neon
includes:
    - vendor/sandermuller/laravel-fluent-validation-phpstan/extension.neon
```

## Rules

### `NoUnboundedArrayEachRule`

Flags `FluentRule::array()->each(...)` (and `FluentRule::list()->each(...)`) chains that have no upper-bound constraint. An unbounded array validated with per-item rules — especially `->exists()`, closure rules, or anything that hits the database — scales linearly with payload size. A caller that sends 10,000 items runs 10,000 per-item checks. Left unchecked, this is a classic N+1 / DoS footgun.

The rule fires on any `->each(...)` call whose receiver is an `ArrayRule` and whose chain has no `->max(N)`, `->between(N, M)`, `->exactly(N)`, and no predefined key whitelist. A rule-string form (`->rule('max:10')`, `->rule(['max', 10])`, `->rule('size:3')`, `->rule('between:1,5')`) also counts as a bound.

```php
namespace App\Http\Requests;

use SanderMuller\FluentValidation\FluentRule;

// reported — no upper bound, per-item DB hit runs once per payload entry
FluentRule::array()->each(FluentRule::string()->exists('users', 'id'));

// fine — explicit ceiling on array size
FluentRule::array()->max(100)->each(FluentRule::string()->exists('users', 'id'));

// fine — trailing bound, chain still classified as bounded
FluentRule::array()->each(FluentRule::string()->exists('users', 'id'))->max(100);

// fine — keys constrained at the factory, array shape is bounded
FluentRule::array(['email', 'name'])->each(FluentRule::string());

// fine — rule-string escape hatch
FluentRule::array()->rule('max:50')->each(FluentRule::string());
```

**Identifier:** `sandermuller.fluentValidation.noUnboundedArrayEach` (stable across versions — suppressions written against this identifier will not rot across minor/patch releases).

**Message:**

> `FluentRule::array()->each(...)` (or `FluentRule::list()->each(...)`) has no upper bound. Unbounded arrays combined with per-item rules (e.g. `exists`, closures) can generate large query counts on big payloads. Add `->max(N)`, `->between(N, M)`, `->exactly(N)`, or constrain keys via `FluentRule::array([...])`.

#### Configuration

```neon
parameters:
    fluentValidationNoUnboundedArrayEach:
        namespaces:
            - App            # default
        excludeNamespaces: []
        boundingMethods:
            - max            # defaults
            - between
            - exactly
        boundingRuleStringPrefixes:
            - max            # defaults
            - size
            - between
```

`namespaces` restricts analysis to chains declared in the listed namespace prefixes (matched against `Scope::getNamespace()`, `str_starts_with`-style). `excludeNamespaces` subtracts; useful for bootstrap / response contract code where a raw `each(...)` without a bound is known-safe.

`boundingMethods` lists fluent methods that count as an upper bound when they appear in the chain. Extend this list when you've registered `ArrayRule::macro('boundedBy', ...)` or similar — e.g. add `boundedBy` so chains using your macro are treated as bounded. Values are lowercase-insensitive (PHP method calls are case-insensitive at runtime; the rule matches the same way).

`boundingRuleStringPrefixes` lists Laravel validation-rule prefixes that count as an upper bound when seen inside `->rule(...)` or `->rule([...])` hops. Extend when your codebase uses a bound-equivalent custom prefix (for example, an `in:...` allowlist where the cardinality of the `in` list is itself the cap, or a project-specific `MyRule::cap:N`).

#### Escape hatches

**Single line**, when the payload is bounded by something the rule can't see (a paginator cap, an upstream form, a feature-flag check):

```php
// @phpstan-ignore-next-line sandermuller.fluentValidation.noUnboundedArrayEach
FluentRule::array()->each(FluentRule::string()->exists('users', 'id'));
```

**Per project**, when a whole subsystem legitimately deals in small, bounded-by-convention arrays:

```neon
parameters:
    ignoreErrors:
        -
            identifier: sandermuller.fluentValidation.noUnboundedArrayEach
            paths:
                - app/Console/Commands/*
```

PHPStan's default `reportUnmatchedIgnoredErrors: true` will turn stale identifier ignores into errors when the underlying call is removed or bounded — keep that default on, so suppressions don't silently hide real fixes.

#### Known limitations

- **Helper-method origin.** `$this->makeBuilder()->each(...)` — when the `ArrayRule` comes from a method return, the factory *type* is known but the *chain* that built it isn't visible. The rule skips this case (zero-false-positive policy). If you want the rule to fire, inline the factory call or add the bound at the helper's definition.
- **Macro-registered bounders.** `ArrayRule::macro('boundedBy', fn (int $n) => $this->max($n))` is invisible to static analysis — the rule will flag chains using your custom bounder unless you add its name to `boundingMethods` in your `phpstan.neon` (see Configuration above).
- **Dynamic keys.** `FluentRule::array($keysVar)->each(...)` is only flagged when the chain also lacks a `max`/`between`/`exactly` hop; PHPStan can't prove the dynamic `$keysVar` is non-empty at analysis time.
- **Unknown-origin receivers.** `$this->builder->each(...)` where `$this->builder` is an injected `ArrayRule` property is not flagged. Same rationale as helper-method origin.

### Out of scope

- `ArrayRule::children(...)` — children are a fixed set, no unbounded risk.
- Per-item DB-heavy rules specifically (`->exists()`, closures). The MVP flags any unbounded `each(...)` regardless of what's inside, to avoid false negatives. Suppress via identifier ignore for cheap-per-item cases.
- Autofix. There is no unambiguous "correct" bound; the rule stays advisory.

## Type extensions

Beyond the rules, the package teaches PHPStan to infer types the runtime API can't declare. No configuration; registering `extension.neon` is enough.

### `rules()` on classes using `HasFluentRules`

`HasFluentRules::rules()` is declared `array<string, mixed>|RuleSet`, because the trait passes `schema()`'s value straight through and a `schema()` may legitimately return either. That union is honest at runtime but too wide at each call site, so code that was clean before migrating `rules()` to `schema()` starts failing:

```php
final class SessionStartedRequest extends BasePlayerRequest
{
    public function rules(): RuleSet
    {
        // Cannot call method merge() on array<string, mixed>|RuleSet.
        return parent::rules()->merge(['position' => FluentRule::integer()->required()]);
    }
}
```

The extension resolves `rules()` to the concrete class's `schema()` return type — `RuleSet` above, so `merge()` resolves. It applies to instance calls and to `parent::`/`self::`/`static::` calls, and mirrors the trait's own gate: a `schema()` whose first parameter isn't a `FluentSchema` is an unrelated method and is left alone, as is a class that declares its own `rules()`.

### `RuleSet::from([...])` validated shape

With `laravel-fluent-validation` 1.36 or later, whose `RuleSet` is generic, `RuleSet::from()` called with a literal rules array resolves to `RuleSet<array{...}>`, so `validate()` and `check()->validated()` return the shape the rules enforce at runtime:

```php
$data = RuleSet::from([
    'id' => FluentRule::integer()->required(),
    'title' => FluentRule::string()->nullable(),
])->validate($payload);

// array{id: float|int|numeric-string, title?: string|null}
```

`validated()` never casts, so each type is the set of raw inputs the chain lets through:

| Base | With `required()` | Without `required()` |
| --- | --- | --- |
| `string()` | `non-empty-string` | `string` |
| `integer()`, `numeric()` | `int\|float\|numeric-string` | `int\|float\|string` |
| `integer(strict: true)` | `int` | `int\|string` |
| `boolean()` | `bool\|0\|1\|'0'\|'1'` | `bool\|0\|1\|string` |

- A key without `required()` is optional. It also admits `string`, because Laravel skips every non-implicit rule for a string that trims to empty, and `''` or `'  '` reaches `validated()` unchanged.
- `nullable()` adds `null` only without `required()`, which rejects null.
- A conditional presence modifier (`sometimes()`, `requiredIf()`, `exclude*()`, `missing*()`, `prohibited*()`, `present*()`, `filled()`) makes the key optional.
- `rule()` is read by rule name. `rule('required')` and `rule('nullable')` act like their methods, Laravel's presence rules (`exclude*`, `sometimes`, `required_*`, `prohibited*`, `missing*`, `present*`, `filled`, and objects such as `Rule::excludeIf()` or `Rule::requiredIf()`) make the key optional, and any other rule, `Password::default()` or a closure included, keeps the type.
- Any other base (`enum()`, `date()`, `email()` and so on) or an unlisted constraint method types the value as `mixed`, but `required()` still keeps the key present.
- `when()`, `unless()`, `whenInput()`, `Rule::when()`, a macro, a `rule()` argument that is not one literal value, or a chain that is not a literal `FluentRule::` (or `FluentSchema`) call turns that key into an optional `mixed`.
- A dotted, wildcard or numeric key, a spread or a non-literal key leaves the whole return type at the declared `array<string, mixed>`.
- On an older `laravel-fluent-validation`, `RuleSet` is not generic and the extension leaves `from()` untouched.

### `validated()` on fluent FormRequests

`$request->validated()` on a `final` FormRequest that uses `HasFluentRules` resolves to the same shape `RuleSet::from()` gets, read from the literal array its `schema()` (or its own `rules()`) returns:

```php
final class StoreVideoRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): array
    {
        return [
            'title' => $rules->string()->required(),
            'duration' => FluentRule::integer(),
        ];
    }
}

$request->validated();               // array{title: non-empty-string, duration?: float|int|string}
$request->validated('title');        // non-empty-string
$request->validated('duration', 0);  // float|int|string
```

- `validated('key', $default)` adds the default's type when the key is optional, and returns the default's type for a key the rules don't declare. A dotted key or a default that may be a `Closure` keeps Laravel's `mixed`.
- The body must be a single `return [...]` or `return RuleSet::from([...])`. A spread, `parent::rules()`, a merge or any other statement keeps `mixed`.
- `validated()` keeps `mixed` when:
  - the class isn't `final`, because a subclass could change its rules;
  - it declares both `schema()` and `rules()`, which the trait merges;
  - it overrides `passedValidation()`, `validated()`, `validator()`, `createDefaultValidator()` or `getValidatorInstance()`.
- `prepareForValidation()` only changes the input the rules then check, so it doesn't stop the inference.
- A value that depends on `$this` reads as an optional `mixed`.
- PHPStan can't connect `$request->has('key')` to `validated()`, so an optional key still reads as `T|null` after such a guard. Pass a default, `validated('key', $fallback)`, or make the rule `required()` when the key is always sent.

## Testing

```bash
composer test
```

Before opening a PR, run the full pipeline (Pint, Rector, PHPStan, tests):

```bash
composer qa
```

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for release notes.

## Contributing

See [CONTRIBUTING.md](CONTRIBUTING.md).

## License

MIT. See [LICENSE.md](LICENSE.md).
