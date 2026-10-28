<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Types;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeFinder;
use PHPStan\Parser\Parser;
use PHPStan\Reflection\ClassReflection;

/**
 * Finds the AST of a method as declared in its source file, so a
 * `schema()` or `rules()` body can be read from a call site in another file.
 *
 * The parser's AST is cached and shared with PHPStan's own analysis of that
 * file, so callers must clone before changing it.
 */
final readonly class MethodAstLocator
{
    public function __construct(private Parser $parser) {}

    public function find(ClassReflection $classReflection, string $methodName): ?ClassMethod
    {
        $nativeClass = $classReflection->getNativeReflection();

        if (! $nativeClass->hasMethod($methodName)) {
            return null;
        }

        $nativeMethod = $nativeClass->getMethod($methodName);
        $file = $nativeMethod->getFileName();
        $line = $nativeMethod->getStartLine();

        if ($file === false || $line === false) {
            return null;
        }

        $method = (new NodeFinder())->findFirst(
            $this->parser->parseFile($file),
            static fn (Node $node): bool => $node instanceof ClassMethod
                && $node->name->toLowerString() === strtolower($methodName)
                && $node->getStartLine() === $line,
        );

        return $method instanceof ClassMethod ? $method : null;
    }
}
