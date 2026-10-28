<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

/**
 * What one modifier hop does to the key's presence and value in `validated()`.
 */
enum ModifierEffect
{
    /** Adds a constraint the value must also pass; keeps the base type. */
    case Constraint;

    /** Keeps presence intact but leaves the value unreadable, so it reads as `mixed`. */
    case Opaque;

    /** `required()`: the key is present whenever validation passes. */
    case Required;

    /** `nullable()`: lets `null` through. */
    case Nullable;

    /** A presence modifier that can leave the key out of `validated()`. */
    case Conditional;

    /** `integer(strict: true)` on a numeric base. */
    case StrictInteger;
}
