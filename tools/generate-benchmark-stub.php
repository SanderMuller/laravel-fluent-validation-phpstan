<?php declare(strict_types=1);

/**
 * Generates a large PHP stub for PHPStan benchmark runs.
 *
 * Usage: php tools/generate-benchmark-stub.php [chain-count]
 * Default: 500 chains
 */
$totalChains = (int) ($argv[1] ?? 500);

// Distribution: 78% non-each, 12% unbounded each (flagged), 10% bounded each (silenced)
$nonEach = (int) round($totalChains * 0.78);
$eachUnbounded = (int) round($totalChains * 0.12);
$eachBounded = $totalChains - $nonEach - $eachUnbounded;

// Only valid camelCase FluentValidation methods
$nonEachChains = [
    // 2-5 hop chains
    'FluentRule::string()->required()->min(1)->max(100)',
    'FluentRule::string()->email()->nullable()',
    'FluentRule::string()->url()->required()',
    'FluentRule::string()->alpha()->max(50)',
    'FluentRule::string()->uuid()->required()',
    "FluentRule::string()->required()->regex('/^[a-z]+$/')",
    'FluentRule::string()->max(255)->nullable()',
    'FluentRule::string()->min(8)->max(72)',
    'FluentRule::string()->min(1)->max(100)',
    'FluentRule::string()->alphaDash()->max(50)',
    "FluentRule::string()->startsWith('prefix')->required()",
    "FluentRule::string()->endsWith('.com')->nullable()",
    'FluentRule::string()->date()->required()',
    'FluentRule::string()->json()->nullable()',
    'FluentRule::string()->timezone()->required()',
    'FluentRule::string()->lowercase()->max(100)',
    'FluentRule::string()->uppercase()->max(100)',
    'FluentRule::string()->ascii()->required()',
    'FluentRule::string()->hexColor()->nullable()',
    'FluentRule::string()->macAddress()->required()',
    'FluentRule::string()->ip()->required()',
    'FluentRule::string()->ipv4()->nullable()',
    'FluentRule::string()->ipv6()->required()',
    'FluentRule::string()->ulid()->required()',
    'FluentRule::string()->between(2, 100)->required()',
    'FluentRule::string()->exactly(10)->required()',
    "FluentRule::string()->regex('/\\d+/')->nullable()",
];

$eachUnboundedChains = [
    'FluentRule::array()->each(FluentRule::string()->required())',
    'FluentRule::array()->each(FluentRule::string()->email())',
    'FluentRule::array()->each(FluentRule::string()->url())',
    'FluentRule::array()->distinct()->each(FluentRule::string())',
    'FluentRule::array()->min(1)->each(FluentRule::string())',
    'FluentRule::array()->nullable()->each(FluentRule::string())',
    'FluentRule::list()->each(FluentRule::string()->required())',
    'FluentRule::list()->each(FluentRule::string()->min(1)->max(50))',
];

$eachBoundedChains = [
    'FluentRule::array()->max(10)->each(FluentRule::string())',
    'FluentRule::array()->between(1, 5)->each(FluentRule::string())',
    'FluentRule::array()->exactly(3)->each(FluentRule::string())',
    "FluentRule::array(['a', 'b', 'c'])->each(FluentRule::string())",
    'FluentRule::array()->each(FluentRule::string())->max(10)',
    'FluentRule::array()->each(FluentRule::string())->between(1, 5)',
    "FluentRule::array()->rule('max:10')->each(FluentRule::string())",
    'FluentRule::list()->max(5)->each(FluentRule::string()->min(1))',
];

$lines = [];
$lines[] = '<?php declare(strict_types=1);';
$lines[] = '';
$lines[] = 'namespace App\\Benchmark;';
$lines[] = '';
$lines[] = 'use SanderMuller\\FluentValidation\\FluentRule;';
$lines[] = 'use SanderMuller\\FluentValidation\\Rules\\ArrayRule;';
$lines[] = 'use SanderMuller\\FluentValidation\\Rules\\StringRule;';
$lines[] = '';
$lines[] = '/**';
$lines[] = " * Auto-generated benchmark stub — {$totalChains} method chains.";
$lines[] = " * {$nonEach} non-each, {$eachUnbounded} unbounded each (flagged), {$eachBounded} bounded each.";
$lines[] = ' */';
$lines[] = 'final class BenchmarkRealistic';
$lines[] = '{';

$idx = 1;

for ($i = 0; $i < $nonEach; $i++) {
    $chain = $nonEachChains[$i % count($nonEachChains)];
    $name = 'n' . str_pad((string) $idx++, 4, '0', STR_PAD_LEFT);
    $lines[] = "    public function {$name}(): StringRule { return {$chain}; }";
}

for ($i = 0; $i < $eachUnbounded; $i++) {
    $chain = $eachUnboundedChains[$i % count($eachUnboundedChains)];
    $name = 'u' . str_pad((string) $idx++, 4, '0', STR_PAD_LEFT);
    $lines[] = "    public function {$name}(): ArrayRule { return {$chain}; }";
}

for ($i = 0; $i < $eachBounded; $i++) {
    $chain = $eachBoundedChains[$i % count($eachBoundedChains)];
    $name = 'b' . str_pad((string) $idx++, 4, '0', STR_PAD_LEFT);
    $lines[] = "    public function {$name}(): ArrayRule { return {$chain}; }";
}

$lines[] = '}';
$lines[] = '';

$output = implode("\n", $lines);
$dest = __DIR__ . '/../tests/Rules/stubs/BenchmarkRealistic.php';
file_put_contents($dest, $output);
echo "Generated {$dest} ({$totalChains} chains, " . strlen($output) . " bytes)\n";
