<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types;

use PHPStan\Testing\PHPStanTestCase;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\TypeCombinator;
use PHPUnit\Framework\Attributes\DataProvider;
use SanderMuller\FluentValidation\RuleSet;
use SanderMuller\LaravelFluentValidationPhpstan\Types\SchemaRulesResolver;

final class SchemaRulesResolverTest extends PHPStanTestCase
{
    /**
     * @return iterable<string, array{Type, bool}>
     */
    public static function returnTypeProvider(): iterable
    {
        yield 'trait fallback, explicit mixed' => [self::union(new MixedType(true)), true];
        yield 'trait fallback, implicit mixed' => [self::union(new MixedType()), true];
        yield 'own rules(): array' => [new ArrayType(new StringType(), new MixedType(true)), false];
        yield 'own rules(): RuleSet' => [new ObjectType(RuleSet::class), false];
        yield 'unrelated union' => [
            TypeCombinator::union(new ObjectType(RuleSet::class), new StringType()),
            false,
        ];
    }

    #[DataProvider('returnTypeProvider')]
    public function testIsTraitFallbackReturnType(Type $returnType, bool $expected): void
    {
        $this->assertSame($expected, (new SchemaRulesResolver())->isTraitFallbackReturnType($returnType));
    }

    private static function union(MixedType $valueType): Type
    {
        return TypeCombinator::union(
            new ArrayType(new StringType(), $valueType),
            new ObjectType(RuleSet::class),
        );
    }
}
