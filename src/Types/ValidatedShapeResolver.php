<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PHPStan\Analyser\Scope;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;

/**
 * Builds the `array{...}` that `validated()` returns for a literal rules array.
 *
 * Only flat literal-string keys are supported. A dotted or wildcard key nests or
 * expands the validated data, a numeric-string key becomes an int key, and a
 * spread or computed key hides the shape — each makes the whole array
 * unresolvable so the declared `array<string, mixed>` stays in place. A value
 * whose chain cannot be read keeps its key as `mixed` and optional.
 */
final readonly class ValidatedShapeResolver
{
    public function __construct(private RuleChainReader $chainReader) {}

    public function resolve(Array_ $rules, Scope $scope): ?Type
    {
        $builder = ConstantArrayTypeBuilder::createEmpty();
        $seen = [];

        foreach ($rules->items as $item) {
            if ($item->unpack || ! $item->key instanceof Expr) {
                return null;
            }

            $key = $this->literalKey($item->key, $scope);

            if ($key === null || isset($seen[$key])) {
                return null;
            }

            $seen[$key] = true;
            $chain = $this->chainReader->read($item->value, $scope);

            $builder->setOffsetValueType(
                new ConstantStringType($key),
                $chain?->valueType() ?? new MixedType(),
                ! $chain instanceof FieldRuleChain || $chain->isOptional(),
            );
        }

        return $builder->getArray();
    }

    private function literalKey(Expr $key, Scope $scope): ?string
    {
        $constantStrings = $scope->getType($key)->getConstantStrings();

        if (count($constantStrings) !== 1) {
            return null;
        }

        $value = $constantStrings[0]->getValue();

        if (str_contains($value, '.') || str_contains($value, '*') || $value === (string) (int) $value) {
            return null;
        }

        return $value;
    }
}
