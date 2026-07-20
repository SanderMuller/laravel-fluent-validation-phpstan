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
     * Shapes are named here and built inside the test. Data providers run
     * before PHPStan's reflection container exists, and constructing an
     * `ObjectType` union there fails with
     * `MissingStaticAccessorInstanceException`.
     *
     * @return iterable<string, array{string, bool}>
     */
    public static function returnTypeProvider(): iterable
    {
        yield 'trait fallback, explicit mixed' => ['union-explicit-mixed', true];
        yield 'trait fallback, implicit mixed' => ['union-implicit-mixed', true];
        yield 'own rules(): array' => ['array', false];
        yield 'own rules(): RuleSet' => ['ruleset', false];
        yield 'unrelated union' => ['union-ruleset-string', false];
    }

    #[DataProvider('returnTypeProvider')]
    public function testIsTraitFallbackReturnType(string $shape, bool $expected): void
    {
        /** Boots the reflection container that `ObjectType` resolves through. */
        self::getContainer();

        $resolver = new SchemaRulesResolver();

        $this->assertSame($expected, $resolver->isTraitFallbackReturnType($this->buildType($shape)));
    }

    private function buildType(string $shape): Type
    {
        return match ($shape) {
            'union-explicit-mixed' => $this->traitUnion(new MixedType(true)),
            'union-implicit-mixed' => $this->traitUnion(new MixedType()),
            'array' => new ArrayType(new StringType(), new MixedType(true)),
            'ruleset' => new ObjectType(RuleSet::class),
            'union-ruleset-string' => TypeCombinator::union(new ObjectType(RuleSet::class), new StringType()),
            default => self::fail("Unknown type shape: {$shape}"),
        };
    }

    private function traitUnion(MixedType $valueType): Type
    {
        return TypeCombinator::union(
            new ArrayType(new StringType(), $valueType),
            new ObjectType(RuleSet::class),
        );
    }
}
