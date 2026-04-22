<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
use SanderMuller\FluentValidation\Rules\ArrayRule;
use SanderMuller\LaravelFluentValidationPhpstan\Parser\FluentValidationChainVisitor;
use SanderMuller\LaravelFluentValidationPhpstan\Rules\Support\BoundingInspector;
use SanderMuller\LaravelFluentValidationPhpstan\Rules\Support\FactoryInspector;
use SanderMuller\LaravelFluentValidationPhpstan\Rules\Support\KeysInspector;
use SanderMuller\LaravelFluentValidationPhpstan\Traits\ChecksNamespace;

/**
 * @implements Rule<MethodCall>
 */
final readonly class NoUnboundedArrayEachRule implements Rule
{
    use ChecksNamespace;

    /** @var string */
    private const IDENTIFIER = 'sandermuller.fluentValidation.noUnboundedArrayEach';

    /** @var class-string<ArrayRule> */
    private const ARRAY_RULE_CLASS = ArrayRule::class;

    private FactoryInspector $factoryInspector;

    private KeysInspector $keysInspector;

    private BoundingInspector $boundingInspector;

    /**
     * @param  list<string>  $namespaces
     * @param  list<string>  $excludeNamespaces
     * @param  list<string>  $boundingMethods
     * @param  list<string>  $boundingRuleStringPrefixes
     */
    public function __construct(
        private array $namespaces,
        private array $excludeNamespaces,
        array $boundingMethods,
        array $boundingRuleStringPrefixes,
    ) {
        $this->factoryInspector = new FactoryInspector();
        $this->keysInspector = new KeysInspector($this->factoryInspector);
        $this->boundingInspector = new BoundingInspector($boundingMethods, $boundingRuleStringPrefixes);
    }

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $this->isEachCall($node)) {
            return [];
        }

        if (! $this->inConfiguredNamespace($scope)) {
            return [];
        }

        if (! $this->receiverIsArrayRule($node, $scope)) {
            return [];
        }

        $root = $node->getAttribute(FluentValidationChainVisitor::CHAIN_ROOT_ATTR);
        if (! $root instanceof Node || ! $this->factoryInspector->isRecognizedFactory($root)) {
            return [];
        }

        if ($this->keysInspector->keysAreBounded($root, $scope)) {
            return [];
        }

        if ($this->boundingInspector->chainHasBoundingMethod($node)) {
            return [];
        }

        if ($this->boundingInspector->chainHasBoundingRule($node, $scope)) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                '`FluentRule::array()->each(...)` (or `FluentRule::list()->each(...)`) has no upper bound. '
                . 'Unbounded arrays combined with per-item rules (e.g. `exists`, closures) can generate large '
                . 'query counts on big payloads. Add `->max(N)`, `->between(N, M)`, `->exactly(N)`, or '
                . 'constrain keys via `FluentRule::array([...])`.'
            )
                ->identifier(self::IDENTIFIER)
                ->line($node->getStartLine())
                ->build(),
        ];
    }

    private function isEachCall(Node $node): bool
    {
        return $node instanceof MethodCall
            && $node->name instanceof Identifier
            && strtolower($node->name->toString()) === 'each';
    }

    private function inConfiguredNamespace(Scope $scope): bool
    {
        return $this->namespaceStartsWithAny($scope, $this->namespaces)
            && ! $this->namespaceStartsWithAny($scope, $this->excludeNamespaces);
    }

    private function receiverIsArrayRule(MethodCall $node, Scope $scope): bool
    {
        return (new ObjectType(self::ARRAY_RULE_CLASS))
            ->isSuperTypeOf($scope->getType($node->var))
            ->yes();
    }
}
