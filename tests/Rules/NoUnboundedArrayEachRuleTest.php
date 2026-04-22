<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Rules;

use PHPStan\Testing\RuleTestCase;
use SanderMuller\LaravelFluentValidationPhpstan\Rules\NoUnboundedArrayEachRule;

/**
 * @extends RuleTestCase<NoUnboundedArrayEachRule>
 */
final class NoUnboundedArrayEachRuleTest extends RuleTestCase
{
    /** @var string */
    private const EXPECTED_MESSAGE = '`FluentRule::array()->each(...)` (or `FluentRule::list()->each(...)`) has no upper bound. Unbounded arrays combined with per-item rules (e.g. `exists`, closures) can generate large query counts on big payloads. Add `->max(N)`, `->between(N, M)`, `->exactly(N)`, or constrain keys via `FluentRule::array([...])`.';

    private ?NoUnboundedArrayEachRule $ruleOverride = null;

    protected function getRule(): NoUnboundedArrayEachRule
    {
        return $this->ruleOverride ?? new NoUnboundedArrayEachRule(
            namespaces: ['App'],
            excludeNamespaces: [],
            boundingMethods: ['max', 'between', 'exactly'],
            boundingRuleStringPrefixes: ['max', 'size', 'between'],
        );
    }

    public static function getAdditionalConfigFiles(): array
    {
        return [
            ...parent::getAdditionalConfigFiles(),
            __DIR__ . '/../../extension.neon',
        ];
    }

    public function testFlagsUnboundedArrayEachCases(): void
    {
        $this->analyse([__DIR__ . '/stubs/UnboundedArrayEach.php'], [
            [self::EXPECTED_MESSAGE, 12],
            [self::EXPECTED_MESSAGE, 17],
            [self::EXPECTED_MESSAGE, 22],
            [self::EXPECTED_MESSAGE, 27],
            [self::EXPECTED_MESSAGE, 32],
            [self::EXPECTED_MESSAGE, 37],
            [self::EXPECTED_MESSAGE, 42],
        ]);
    }

    public function testFlagsUnboundedListEachCases(): void
    {
        $this->analyse([__DIR__ . '/stubs/UnboundedListEach.php'], [
            [self::EXPECTED_MESSAGE, 12],
            [self::EXPECTED_MESSAGE, 17],
        ]);
    }

    public function testFlagsUnboundedMixedCaseCases(): void
    {
        $this->analyse([__DIR__ . '/stubs/UnboundedMixedCase.php'], [
            [self::EXPECTED_MESSAGE, 12],
            [self::EXPECTED_MESSAGE, 17],
        ]);
    }

    public function testDoesNotFlagBoundedArrayCases(): void
    {
        $this->analyse([__DIR__ . '/stubs/BoundedArray.php'], []);
    }

    public function testDoesNotFlagBoundedArrayKeyCases(): void
    {
        $this->analyse([__DIR__ . '/stubs/BoundedArrayKeys.php'], []);
    }

    public function testDoesNotFlagBoundedRuleEscapeHatchCases(): void
    {
        $this->analyse([__DIR__ . '/stubs/BoundedRuleEscapeHatch.php'], []);
    }

    public function testDoesNotFlagOutsideConfiguredNamespace(): void
    {
        $this->analyse([__DIR__ . '/stubs/OutsideNamespace.php'], []);
    }

    public function testDoesNotFlagUnknownOriginReceiver(): void
    {
        $this->analyse([__DIR__ . '/stubs/UnknownOrigin.php'], []);
    }

    public function testDynamicKeysFlaggedOnlyWhenChainHasNoBound(): void
    {
        $this->analyse([__DIR__ . '/stubs/DynamicKeys.php'], [
            [self::EXPECTED_MESSAGE, 15],
        ]);
    }

    public function testNullableKeysUnionIsUnbounded(): void
    {
        $this->analyse([__DIR__ . '/stubs/NullableKeysUnion.php'], [
            [self::EXPECTED_MESSAGE, 20],
        ]);
    }

    public function testNewArrayRuleDirectInstantiation(): void
    {
        $this->analyse([__DIR__ . '/stubs/NewArrayRuleDirect.php'], [
            [self::EXPECTED_MESSAGE, 11],
        ]);
    }

    public function testDefaultConfigFlagsCustomBoundingMethodStub(): void
    {
        $this->analyse([__DIR__ . '/stubs/CustomBoundingMethod.php'], [
            [self::EXPECTED_MESSAGE, 18],
        ]);
    }

    public function testExtendedBoundingMethodsSilenceCustomBounder(): void
    {
        $this->ruleOverride = new NoUnboundedArrayEachRule(
            namespaces: ['App'],
            excludeNamespaces: [],
            boundingMethods: ['max', 'between', 'exactly', 'contains'],
            boundingRuleStringPrefixes: ['max', 'size', 'between'],
        );

        $this->analyse([__DIR__ . '/stubs/CustomBoundingMethod.php'], []);
    }

    public function testDefaultConfigFlagsCustomRuleStringStub(): void
    {
        $this->analyse([__DIR__ . '/stubs/CustomBoundingRuleString.php'], [
            [self::EXPECTED_MESSAGE, 17],
        ]);
    }

    public function testExtendedRuleStringPrefixesSilenceCustomPrefix(): void
    {
        $this->ruleOverride = new NoUnboundedArrayEachRule(
            namespaces: ['App'],
            excludeNamespaces: [],
            boundingMethods: ['max', 'between', 'exactly'],
            boundingRuleStringPrefixes: ['max', 'size', 'between', 'in'],
        );

        $this->analyse([__DIR__ . '/stubs/CustomBoundingRuleString.php'], []);
    }

    public function testIdentifierIsStable(): void
    {
        $errors = $this->gatherAnalyserErrors([__DIR__ . '/stubs/UnboundedArrayEach.php']);

        $this->assertNotEmpty($errors);

        foreach ($errors as $error) {
            $this->assertSame('sandermuller.fluentValidation.noUnboundedArrayEach', $error->getIdentifier());
        }
    }
}
