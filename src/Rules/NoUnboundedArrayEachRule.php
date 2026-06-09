<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Rules;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
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

    /**
     * @param  list<string>  $namespaces
     * @param  list<string>  $excludeNamespaces
     */
    public function __construct(
        private array $namespaces,
        private array $excludeNamespaces,
        private FactoryInspector $factoryInspector,
        private KeysInspector $keysInspector,
        private BoundingInspector $boundingInspector,
    ) {}

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /** @param MethodCall $node */
    public function processNode(Node $node, Scope $scope): array
    {
        if (! $this->isEachCall($node)) {
            return [];
        }

        if (! $this->inConfiguredNamespace($scope)) {
            return [];
        }

        // Cheap factory check before any PHPStan type inference. The visitor stamps
        // CHAIN_ROOT_ATTR on every each() hop; we confirm the root is a recognized
        // factory here (at analysis time, after name resolution) so that Collection::each()
        // and similar non-FluentRule calls are rejected without triggering getType().
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

    private function isEachCall(MethodCall $node): bool
    {
        return $node->name instanceof Identifier
            && $node->name->toLowerString() === 'each';
    }

    private function inConfiguredNamespace(Scope $scope): bool
    {
        return $this->namespaceStartsWithAny($scope, $this->namespaces)
            && ! $this->namespaceStartsWithAny($scope, $this->excludeNamespaces);
    }
}
