<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Analyser\ScopeContext;
use PHPStan\Analyser\ScopeFactory;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Type;
use SanderMuller\FluentValidation\RuleSet;
use SanderMuller\LaravelFluentValidationPhpstan\Rules\Support\FactoryInspector;

/**
 * The `array{...}` that a fluent FormRequest's `validated()` returns, read from
 * the literal array its `schema()` or own `rules()` returns.
 *
 * {@see FormRequestEligibility} decides which classes are read at all.
 */
final class FormRequestShapeResolver
{
    /** @var array<string, Type|false> */
    private array $shapes = [];

    public function __construct(
        private readonly FormRequestEligibility $eligibility,
        private readonly SchemaRulesResolver $schemaRules,
        private readonly MethodAstLocator $astLocator,
        private readonly RuleSetArrayReader $arrayReader,
        private readonly FactoryInspector $factoryInspector,
        private readonly ScopeFactory $scopeFactory,
    ) {}

    public function resolve(ClassReflection $classReflection): ?Type
    {
        $shape = $this->shapes[$classReflection->getName()] ??= $this->resolveUncached($classReflection) ?? false;

        return $shape === false ? null : $shape;
    }

    private function resolveUncached(ClassReflection $classReflection): ?Type
    {
        if (! $this->eligibility->isEligible($classReflection)) {
            return null;
        }

        $rulesMethod = $classReflection->getNativeMethod('rules');
        $hasFluentSchema = $this->schemaRules->hasFluentSchema($classReflection);

        if ($this->schemaRules->isTraitFallback($rulesMethod)) {
            return $hasFluentSchema ? $this->readMethod($classReflection, 'schema') : new ConstantArrayType([], []);
        }

        return $hasFluentSchema ? null : $this->readMethod($classReflection, 'rules');
    }

    private function readMethod(ClassReflection $classReflection, string $methodName): ?Type
    {
        $method = $this->astLocator->find($classReflection, $methodName);

        if (! $method instanceof ClassMethod) {
            return null;
        }

        $rules = $this->returnedRules($method);

        if (! $rules instanceof Array_) {
            return null;
        }

        $fileName = $classReflection->getNativeReflection()->getMethod($methodName)->getFileName();

        if ($fileName === false) {
            return null;
        }

        $scope = $this->scopeFactory->create(ScopeContext::create($fileName))->enterClass($classReflection);

        return $this->arrayReader->read($rules, $this->schemaVariable($method), $scope);
    }

    /**
     * The rules array of a body that is exactly `return [...]` or
     * `return RuleSet::from([...])`. Anything else, such as a second statement,
     * a merge or a spread, is not read.
     */
    private function returnedRules(ClassMethod $method): ?Array_
    {
        $statements = $method->stmts ?? [];

        if (count($statements) !== 1 || ! $statements[0] instanceof Return_) {
            return null;
        }

        $returned = $statements[0]->expr;

        if ($returned instanceof StaticCall
            && $this->factoryInspector->classNameIs($returned->class, RuleSet::class)
            && $this->factoryInspector->staticCallNameIn($returned, ['from' => true])
            && ! $returned->isFirstClassCallable()
            && count($returned->getArgs()) === 1
            && ! $returned->getArgs()[0]->unpack) {
            $returned = $returned->getArgs()[0]->value;
        }

        return $returned instanceof Array_ ? $returned : null;
    }

    private function schemaVariable(ClassMethod $method): ?string
    {
        $variable = ($method->params[0] ?? null)?->var;

        return $variable instanceof Variable && is_string($variable->name) ? $variable->name : null;
    }
}
