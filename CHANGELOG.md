# Changelog

All notable changes to `laravel-fluent-validation-phpstan` will be documented in this file.

## 0.4.0 - 2026-10-28

<!-- verified-sha: f78bede643ae3c836387d812f4e35e04511410e4 -->
### Added

- `RuleSet::from([...])` with a literal rules array now resolves to `RuleSet<array{...}>`, so `validate()` and `check()->validated()` return the shape the rules enforce at runtime instead of `array<string, mixed>` (#8). Requires `sandermuller/laravel-fluent-validation` 1.36 or later; on older versions the extension leaves `from()` untouched.
  
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
  
  - A key without `required()` is optional and also admits `string`, because Laravel skips non-implicit rules for a string that trims to empty.
  - `nullable()` adds `null` only without `required()`.
  - Conditional presence modifiers (`sometimes()`, `requiredIf()`, `exclude*()`, `missing*()`, `prohibited*()`, `present*()`, `filled()`) make the key optional.
  - `rule()`, `whenInput()`, macros, other bases and non-literal values turn that key into an optional `mixed`. Dotted, wildcard, numeric or computed keys leave the whole return type at `array<string, mixed>`.
  
  Projects on laravel-fluent-validation 1.36 may see new, correct errors where code reads a key the rules don't declare.
  

### Internal

- Replaced the abandoned `rector/type-perfect` dev dependency with `tomasvotruba/type-coverage` `^2.5.1`, which now bundles it.

**Full Changelog**: https://github.com/SanderMuller/laravel-fluent-validation-phpstan/compare/0.3.0...0.4.0

## 0.3.0 - 2026-07-20

### Added

#### `rules()` now resolves to the class's own `schema()` return type

`HasFluentRules::rules()` is declared `array<string, mixed>|RuleSet`. That union is the honest runtime type — the trait passes `schema()`'s value straight through, and a `schema()` may legitimately return either — but it is too wide at every call site. Code that was clean before migrating `rules()` to `schema()` started failing:

```
Cannot call method merge() on array<string, mixed>|SanderMuller\FluentValidation\RuleSet.
  [identifier=method.nonObject]

Generator expects value type array{SanderMuller\FluentValidation\RuleSet, string},
array{array<string, mixed>|SanderMuller\FluentValidation\RuleSet, 'delete_interactions'} given.
  [identifier=generator.valueType]


```
Two shapes hit it: a subclass extending its parent through `parent::rules()->merge([...])`, and test data providers yielding `$request->rules()` into a provider typed `array{RuleSet}`. Both are correct code, and the error count grows with each request converted to `schema()`.

The package now ships a dynamic return type extension that resolves `rules()` to the concrete class's `schema()` return type — `RuleSet` for a `schema(FluentSchema $rules): RuleSet`, `array` for one returning `array`. Instance calls and `parent::` / `self::` / `static::` calls are both covered.

It replicates the trait's own gates rather than matching on the method name, so it stays silent where the trait would: a `schema()` whose first parameter isn't a `FluentSchema` is an unrelated method and is left alone, as is a class declaring its own `rules()`.

No configuration. Registering `extension.neon` — automatic with `phpstan/extension-installer` — is enough.

Sourced from production dogfooding of a large in-flight `rules()` → `schema()` migration.

### Internal

- The minimum `sandermuller/laravel-fluent-validation` dev requirement moved to `^1.33.0`, the first release carrying the `schema()` builder this extension reasons about. Consumers are unaffected — the package has never required the runtime library.
- `AddSeeTestAnnotationRector` is now skipped. The `@see` it adds resolves to an import of a test class, and `tests/` is `export-ignore`d, so the import was unresolvable in a consumer's vendor directory.

**Full Changelog**: https://github.com/SanderMuller/laravel-fluent-validation-phpstan/compare/0.2.0...0.3.0

## 0.1.0 - 2026-04-22

First public release of `sandermuller/laravel-fluent-validation-phpstan`, a PHPStan extension that flags misuse of [`sandermuller/laravel-fluent-validation`](https://github.com/sandermuller/laravel-fluent-validation) in consumer projects.

### What ships

One rule:

- **`NoUnboundedArrayEachRule`** — identifier `sandermuller.fluentValidation.noUnboundedArrayEach`.

Flags `FluentRule::array()->each(...)` and `FluentRule::list()->each(...)` chains that have no upper-bound constraint. An unbounded array validated with per-item rules — especially `->exists()`, closure rules, custom `Rule` objects, or anything hitting the database — scales linearly with payload size. A caller that sends 10,000 items runs 10,000 per-item checks. Left unchecked, this is a classic N+1 / DoS footgun.

The rule fires on any `->each(...)` call whose receiver is an `ArrayRule` and whose chain has no `->max(N)`, `->between(N, M)`, `->exactly(N)`, no predefined key whitelist, and no rule-string bound (`->rule('max:10')`, `->rule(['max', 10])`, `->rule('size:3')`, `->rule('between:1,5')`).

See README for configuration (`namespaces`, `excludeNamespaces`, `boundingMethods`, `boundingRuleStringPrefixes`), escape hatches (identifier ignore, per-path suppression), and known limitations (helper-method origin, macro-registered bounders, dynamic keys, unknown-origin receivers).

### Compatibility

- PHP 8.2, 8.3, 8.4
- PHPStan ^2.1.8
- Laravel 11, 12, 13 (host-app validation code; the extension itself has no runtime Laravel dependency)
- `sandermuller/laravel-fluent-validation` ^1.19

CI matrix: 17 cells (`PHP {8.2, 8.3, 8.4} × Laravel {^11.0, ^12.0, ^13.0} × stability {prefer-lowest, prefer-stable}` minus `PHP 8.2 × ^13.0` — Laravel 13 requires PHP ≥8.3).

### Install

```bash
composer require --dev sandermuller/laravel-fluent-validation-phpstan


```
With [`phpstan/extension-installer`](https://github.com/phpstan/extension-installer) the rule auto-registers. Otherwise include the extension manually:

```neon
includes:
    - vendor/sandermuller/laravel-fluent-validation-phpstan/extension.neon


```
## What's Changed

* Bump peter-evans/create-pull-request from 7.0.8 to 8.1.1 by @dependabot[bot] in https://github.com/SanderMuller/laravel-fluent-validation-phpstan/pull/1

## New Contributors

* @dependabot[bot] made their first contribution in https://github.com/SanderMuller/laravel-fluent-validation-phpstan/pull/1

**Full Changelog**: https://github.com/SanderMuller/laravel-fluent-validation-phpstan/commits/0.1.0
