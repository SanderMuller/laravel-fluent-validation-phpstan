<?php declare(strict_types=1);

/**
 * Micro-benchmark for FluentValidationChainVisitor and NoUnboundedArrayEachRule hot paths.
 *
 * Usage: php benchmark.php [iterations]
 */

require_once __DIR__ . '/vendor/autoload.php';

use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use PhpParser\PhpVersion;
use SanderMuller\LaravelFluentValidationPhpstan\Parser\FluentValidationChainVisitor;

$iterations = (int) ($argv[1] ?? 200);

$code = file_get_contents(__DIR__ . '/tests/Rules/stubs/BenchmarkLargeFile.php');

if ($code === false) {
    echo "ERROR: Could not read benchmark stub\n";
    exit(1);
}

$parser = (new ParserFactory())->createForVersion(PhpVersion::fromString('8.3'));
$stmts = $parser->parse($code);

if ($stmts === null) {
    echo "ERROR: Could not parse benchmark stub\n";
    exit(1);
}

// Warm up (parse once, resolver once — not what we're benchmarking)
$nameResolver = new NameResolver();
$traverser = new NodeTraverser();
$traverser->addVisitor($nameResolver);
$stmts = $traverser->traverse($stmts);

// Benchmark: only the FluentValidationChainVisitor traversal
$visitor = new FluentValidationChainVisitor();
$traverser = new NodeTraverser();
$traverser->addVisitor($visitor);

// Warm up JIT/opcache
for ($i = 0; $i < 5; $i++) {
    $traverser->traverse($stmts);
}

$start = hrtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $traverser->traverse($stmts);
}
$end = hrtime(true);

$totalMs = ($end - $start) / 1_000_000;
$perIterMs = $totalMs / $iterations;

echo "FluentValidationChainVisitor traversal benchmark\n";
echo "Stub: BenchmarkLargeFile.php (80 non-each + 20 each-containing chains)\n";
echo "Iterations: {$iterations}\n";
echo sprintf("Total: %.2f ms\n", $totalMs);
echo sprintf("Per iteration: %.4f ms (%.2f µs)\n", $perIterMs, $perIterMs * 1000);
echo sprintf("Throughput: %.0f traversals/sec\n", 1000 / $perIterMs);
echo "\n";
