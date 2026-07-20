# Fluent-Validation PHPStan Rules

This is `sandermuller/laravel-fluent-validation-phpstan`, a PHPStan extension package that flags misuse of [`sandermuller/laravel-fluent-validation`](https://github.com/sandermuller/laravel-fluent-validation) in consumer projects. This is **not** a Laravel application — it is a standalone Composer package.

## Project Structure

```
src/
├── Parser/            # Custom PHPStan node visitors (chain-metadata annotations)
├── Rules/             # PHPStan rules (one class per rule)
├── Traits/            # Shared traits (ChecksNamespace)
└── Types/             # Dynamic return type extensions
tests/
├── Rules/             # Tests for each rule (PHPStan RuleTestCase)
│   └── stubs/         # Test fixture PHP files referencing FluentRule
├── Types/             # Tests for type extensions (PHPStan TypeInferenceTestCase)
│   └── stubs/         # Fixtures carrying assertType() calls
extension.neon         # PHPStan extension registration
phpstan.neon.dist      # PHPStan analysis configuration
pint.json              # Laravel Pint code style config
```

Companion packages:

- [`sandermuller/laravel-fluent-validation`](https://github.com/sandermuller/laravel-fluent-validation) — the runtime API these rules target.
- [`sandermuller/fluent-validation-rector`](https://github.com/sandermuller/fluent-validation-rector) — auto-fix counterpart for migration tasks.

## Dependencies

- **PHP**: ^8.3
- **PHPStan**: ^2.1.8
- `sandermuller/laravel-fluent-validation`: `^1.19` (dev-only; consumers supply their own installed version)

## Development Commands

```bash
composer test                # Run PHPUnit tests
composer fix-cs              # Run Laravel Pint formatter (alias: composer format)
composer phpstan             # Run PHPStan analysis
composer phpstan-clear-cache # Clear PHPStan cache
composer rector              # Run Rector transformations
composer qa                  # Run format, rector, phpstan, test
composer sync-ai             # Re-sync AI agent skills and guidelines
```

## Repository

- **Owner**: `sandermuller`
- **Repository**: `laravel-fluent-validation-phpstan`
- **Default branch**: `main`

---

## PHP Conventions

- Always use `declare(strict_types=1);`
- Use `private` visibility by default for methods, properties, and constants
- Always use curly braces for control structures, even for single-line bodies
- Use PHP 8 constructor property promotion
- Always use explicit return type declarations
- Use appropriate PHP type hints for all method parameters
- Add a space after the unary not operator: `if (! $foo)`
- Omit docblocks when methods are fully type-hinted
- Prefer string interpolation over `sprintf` and concatenation
- Never use `empty()` — use explicit checks instead
- Prefer PHPDoc blocks over inline comments

---

## Testing

- Tests use PHPStan's `RuleTestCase` base class
- Each rule has a corresponding test in `tests/Rules/`
- Test stubs (fixture PHP/Blade files) live alongside the tests in `stubs/` subdirectories
- Run all tests: `composer test`
- Run specific test: `vendor/bin/phpunit --filter=TestClassName`
- Every change must have test coverage — write or update tests, then run them

## Creating a New Rule

1. Create the rule class in `src/Rules/` implementing PHPStan's `Rule<T>` interface
2. Register it in `extension.neon` — under `rules:` if the rule has no constructor dependencies, or under `services:` with the `phpstan.rules.rule` tag when it needs DI (e.g. `ReflectionProvider`)
3. Create test stub files in `tests/Rules/stubs/` (or a sibling `stubs/` directory next to the test)
4. Create a test extending `PHPStan\Testing\RuleTestCase` in `tests/Rules/`
5. Use the `ChecksNamespace` trait if the rule needs to filter by namespace prefix
6. Run `composer fix-cs` and `composer phpstan` before finalizing

## Creating a Type Extension

1. Create the class in `src/Types/` implementing `DynamicMethodReturnTypeExtension` (instance calls) or `DynamicStaticMethodReturnTypeExtension` (`parent::`/`self::`/`static::` calls)
2. Register it in `extension.neon` under `services:` with the `phpstan.broker.dynamicMethodReturnTypeExtension` or `phpstan.broker.dynamicStaticMethodReturnTypeExtension` tag
3. Create fixtures carrying `assertType()` calls in `tests/Types/stubs/`, and a test extending `PHPStan\Testing\TypeInferenceTestCase` in `tests/Types/`
4. Add the stub directory to the `classmap` in `composer.json` when a fixture file declares more than one class
5. Run `composer fix-cs` and `composer phpstan` before finalizing

**`getClass()` never matches a trait.** PHPStan resolves these extensions against
the class, its parents and its interfaces only
(`DynamicReturnTypeExtensionRegistry::getDynamicExtensionsForType()`). Anchor on
a concrete base class and check trait use inside the extension instead — a
trait-anchored extension registers fine and silently never runs.

**Mutation-check every fixture.** An extension that returns `null` on every call
leaves the declared type in place, which is often what a naive assertion expects
anyway. Temporarily break the extension and confirm the fixture fails; a
type-inference test that cannot fail is worse than none.

**Any test touching PHPStan type APIs must extend `PHPStanTestCase`.** The
reflection container is only initialized for its subclasses. A plain
`PHPUnit\Framework\TestCase` appears to work when the suite happens to run a
`PHPStanTestCase` first and fails with `MissingStaticAccessorInstanceException`
in isolation.

## Quality Standards

- PHPStan level: `max`
- Type coverage: 100% (return, param, property, declare)
- Cognitive complexity: class max 12, function max 10
- Code style: Laravel Pint with `laravel` preset

---

## PHPStan Extension Notes

**Visitor timing:** `richParserNodeVisitor` runs before PHPStan's name-resolution
pass. At visitor time, `Name` nodes still hold the short/aliased form (e.g.
`FluentRule`), not the FQCN (`SanderMuller\FluentValidation\FluentRule`).
Any FQCN string comparison inside the visitor silently returns false.
Move class-identity checks to the rule's `processNode`, which runs at analysis
time after `NameResolver` has converted `Name` → `Name\FullyQualified`.

---

## Fixing PHPStan Errors

When fixing a PHPStan error, first decide whether it represents a runtime bug a test could catch — and if so, write that test before the fix.

### Process

1. **Assess testability** — does the error represent a runtime bug a test could reproduce (a wrong argument type, a missing method, an incorrect return type used downstream)?
2. **Write the test first** — if a test can catch it, write a failing test that reproduces the error before applying the fix.
3. **Fix the code** — apply the fix so both the PHPStan error and the new test pass.
4. **Verify both** — confirm PHPStan reports no error and the test passes.

### When to Write a Test

Write a test when the PHPStan error indicates a fault that would surface at runtime:

- A method call on a value of the wrong type
- Missing or incorrect arguments to a function or method
- A return-type mismatch that would break callers
- Accessing a property or method that does not exist
- Any type error that would manifest as a runtime exception

### When to Skip the Test

Skip the test when the error is purely static and cannot cause a runtime failure:

- Missing return-type declarations
- PHPDoc mismatches with no runtime impact
- Unused variables or imports
- Generic-type parameter issues

---

## Verification Before Completion

Before claiming any work is complete or successful, run the verification command fresh and confirm the output. Evidence before claims, always.

### Required Before Any Completion Claim

1. **Run** the relevant command (in the current message, not from memory)
2. **Read** the full output
3. **Confirm** it supports the claim
4. **Then** state the result with evidence

| Claim            | Required verification                                            |
|------------------|------------------------------------------------------------------|
| Tests pass       | The project's test command, output showing 0 failures            |
| Code style clean | The project's formatter/style checker, output showing no changes |
| Linting clean    | The project's linter, output showing 0 errors                    |
| Types check      | The project's type checker, output showing 0 errors              |
| Bug fixed        | The previously failing test now passes                           |
| Feature complete | All related tests pass                                           |

Use the project's own commands — check its `composer.json` / `package.json` scripts, CI config, or sibling docs to find them. Do not assume a specific tool.

### Delegating the checks

Where the project has dedicated quality-check skills synced, delegate to them — `backend-quality` for backend files, `frontend-quality` for frontend files, both when a change spans both. Otherwise, run the project's own equivalent commands directly.

### Never Use Without Evidence

- "should work now"
- "that should fix it"
- "looks correct"
- "I'm confident this works"

These phrases indicate missing verification. Run the command first, then report what actually happened.

---

# Package Boost Guidelines

These guidelines replace Laravel Boost's default foundation for
repositories that ship as Composer packages — Laravel-targeted or
framework-agnostic. The framing, tooling, and trade-offs differ from
application development; follow this version when working inside a
package codebase.

## Foundational Context

This codebase is a **Composer package**, not an application. The rules
below hold regardless of which framework (if any) the package targets.

- There is no `app/`, `bootstrap/`, `routes/`, `.env`, or database by
  default. Tooling that assumes an application context (e.g. running
  `php artisan` against the package itself) does not apply.
- The primary artefact is the package's public API — entry-point
  classes, service providers, exposed contracts. Everything else is
  scaffolding.
- Downstream consumers depend on this package via Composer. Every
  public change is a user-facing API change governed by semver.
- `composer.json` is the source of truth for supported PHP versions
  and any framework constraints. Check `require.php` (and any
  `require.<framework>/*` entries) before using version-specific
  features.

## Source Layout

- `src/` — package source, PSR-4 autoloaded per `composer.json`
- `tests/` — Pest or PHPUnit suite
- `config/` — publishable defaults shipped with the package, when
  applicable
- `resources/` — views, translations, Boost skills / guidelines, when
  applicable
- `database/migrations`, `database/factories` — only if the package
  ships them
- `workbench/` — developer-only Testbench scaffolding when Testbench
  is in use; never shipped

Check sibling files before inventing structure. Do not introduce new
top-level directories without a clear reason.

## Tests Are the Specification

The package has no running application to click through. Tests are how
behaviour is pinned down.

- Write tests alongside any behavioural change.
- Do not create "verification scripts" when a test can prove the same
  thing.
- Run the project's configured test runner (`vendor/bin/pest` or
  `vendor/bin/phpunit`) before claiming a change is done.

## Public API Discipline

- Every `public`, `protected`, or exported symbol is part of the
  package's surface. Breaking changes require a major version bump.
- Prefer `final` classes and `private`/`@internal` markers for
  anything not intended for extension.
- Keep config keys, published asset paths, and service container
  bindings stable across patch and minor versions.

## Conventions

- Match existing code style, naming, and structural patterns — check
  sibling files before writing new ones.
- Use descriptive names (`resolvePublishDestination`, not `resolve()`).
- Reuse existing helpers before adding new ones.
- Do not add dependencies without approval; every new `require` is a
  constraint downstream consumers inherit.

## Extending boost-core

If your package authors a custom `FileEmitter` (to write a file like
`.mcp.json` into the host during `boost sync`), declare the
`boost-extension` tag in your `boost.php` `withTags([...])`. That pulls
the `writing-file-emitter` skill — gated off by default so consumers
who do not extend the engine don't carry it, which is why an
emitter-authoring package has to opt in explicitly. The same tag pulls
`skill-authoring` for writing boost-family skills.

## Documentation Files

Only create or edit documentation (README, CHANGELOG, docs/) when
explicitly requested or when a behaviour change requires it.

## Replies

Be concise. Focus on what changed and why. Skip restating what the
diff already shows.

---

# Release Automation

Conventions the package-boost family shares for release flow. The
procedural detail lives in the `pre-release` and `release-notes`
skills — loaded on-demand, not pinned here.

## CHANGELOG is CI-managed

`.github/workflows/update-changelog.yml` prepends the release body to
`CHANGELOG.md` on `release: released` and commits to the release's
target branch (typically `main`). Don't hand-edit `CHANGELOG.md` as
part of a release. Post-release typo fixes are committed directly.

## Release notes live in `internal/release-notes-<version>.md`

`internal/` is gitignored — drafts stay local. The notes file becomes
the release body. The first line pins the green commit so the pre-tag
gate can fail closed on drift:

```
<!-- verified-sha: <full sha> -->
```

## Tag and title

- Tag: bare version (`0.7.0`) — Composer and Packagist read the tag.
- Release title: `v`-prefixed (`v0.7.0`) — cosmetic.
- Notes file: bare (`internal/release-notes-0.7.0.md`).

## Agent handoff

Agents stop at the ready-to-tag handoff. The user runs the pre-tag
gate and publishes the release (GitHub UI, `gh`, or otherwise). See
the `pre-release` skill for the full procedure and the no-release-create
rule.
