# Changelog

All notable changes to `laravel-fluent-validation-phpstan` will be documented in this file.

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
