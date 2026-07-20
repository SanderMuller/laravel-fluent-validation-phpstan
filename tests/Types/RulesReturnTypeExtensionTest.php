<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types;

use Override;
use PHPStan\Testing\TypeInferenceTestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class RulesReturnTypeExtensionTest extends TypeInferenceTestCase
{
    /**
     * @return iterable<mixed>
     */
    public static function dataFileAsserts(): iterable
    {
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/SchemaReturnsRuleSet.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/SchemaReturnsArray.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/NoSchema.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/UnrelatedSchema.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/InheritedSchema.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/OwnRules.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/ParentRulesCall.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/UnrelatedStaticCall.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/OwnUnionRules.php');
        yield from self::gatherAssertTypes(__DIR__ . '/stubs/NullableSchemaParameter.php');
    }

    #[DataProvider('dataFileAsserts')]
    public function testFileAsserts(string $assertType, string $file, mixed ...$args): void
    {
        $this->assertFileAsserts($assertType, $file, ...$args);
    }

    /**
     * @return array<string>
     */
    #[Override]
    public static function getAdditionalConfigFiles(): array
    {
        return [__DIR__ . '/rules-return-type.neon'];
    }
}
