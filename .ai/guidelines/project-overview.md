# Fluent-Validation PHPStan Rules

This is `sandermuller/laravel-fluent-validation-phpstan`, a PHPStan extension package that flags misuse of [`sandermuller/laravel-fluent-validation`](https://github.com/sandermuller/laravel-fluent-validation) in consumer projects. This is **not** a Laravel application — it is a standalone Composer package.

## Project Structure

```
src/
├── Parser/            # Custom PHPStan node visitors (chain-metadata annotations)
├── Rules/             # PHPStan rules (one class per rule)
└── Traits/            # Shared traits (ChecksNamespace)
tests/
├── Rules/             # Tests for each rule (PHPStan RuleTestCase)
│   └── stubs/         # Test fixture PHP files referencing FluentRule
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
