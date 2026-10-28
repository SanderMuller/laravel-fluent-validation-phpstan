<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PHPStan\Type\Accessory\AccessoryNonEmptyStringType;
use PHPStan\Type\Accessory\AccessoryNumericStringType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;

/**
 * What one literal `FluentRule::<base>()->...` chain guarantees about the value
 * `validated()` returns for its key.
 *
 * `validated()` never casts, so every type here is the set of raw inputs the
 * chain lets through — `integer()` passes `'12'` and `12.0` unchanged.
 */
final readonly class FieldRuleChain
{
    public const string BASE_STRING = 'string';

    public const string BASE_NUMERIC = 'numeric';

    public const string BASE_BOOLEAN = 'boolean';

    /**
     * @param  self::BASE_*  $base
     * @param  bool  $strictInteger  `integer:strict`, which only accepts a PHP `int`
     * @param  bool  $required  a plain `required()`, which rejects null and blank strings whenever the key is validated
     * @param  bool  $conditional  a modifier that can leave the key out of `validated()` even alongside `required()`
     */
    public function __construct(
        private string $base,
        private bool $strictInteger,
        private bool $required,
        private bool $nullable,
        private bool $conditional,
    ) {}

    public function isOptional(): bool
    {
        return ! $this->required || $this->conditional;
    }

    /**
     * Without `required()`, Laravel skips every non-implicit rule for a string
     * that trims to empty, so `''` and `'  '` reach `validated()` whatever the
     * base. PHPStan cannot express a whitespace-only string, so the union widens
     * to `string`.
     */
    public function valueType(): Type
    {
        $type = $this->baseType();

        if ($this->required) {
            return $type;
        }

        $type = TypeCombinator::union($type, new StringType());

        return $this->nullable ? TypeCombinator::addNull($type) : $type;
    }

    private function baseType(): Type
    {
        return match ($this->base) {
            self::BASE_STRING => $this->required
                ? new IntersectionType([new StringType(), new AccessoryNonEmptyStringType()])
                : new StringType(),
            self::BASE_NUMERIC => $this->strictInteger
                ? new IntegerType()
                : TypeCombinator::union(
                    new IntegerType(),
                    new FloatType(),
                    new IntersectionType([new StringType(), new AccessoryNumericStringType()]),
                ),
            self::BASE_BOOLEAN => TypeCombinator::union(
                new BooleanType(),
                new ConstantIntegerType(0),
                new ConstantIntegerType(1),
                new ConstantStringType('0'),
                new ConstantStringType('1'),
            ),
        };
    }
}
