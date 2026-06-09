#!/usr/bin/env bash
# PHPStan full-analysis benchmark.
#
# Runs two configs back-to-back:
#   - with extension   (phpstan-benchmark.neon)
#   - without extension (phpstan-benchmark-noext.neon)
# so we can measure the overhead our extension adds.
#
# Usage: bash benchmark-phpstan.sh [runs]
# Default: 5 cold runs per config

set -uo pipefail

RUNS="${1:-5}"

run_config() {
    local label="$1"
    local config="$2"
    local cache="$3"

    echo "${label}"
    echo "  Config: ${config}"

    local total=0
    local min=999999
    local max=0

    for i in $(seq 1 "$RUNS"); do
        rm -rf "$cache"

        local start
        start=$(php -r 'echo hrtime(true);')

        vendor/bin/phpstan analyse \
            --configuration="$config" \
            --memory-limit=512M \
            --no-progress \
            --error-format=raw \
            > /dev/null 2>&1 || true

        local end
        end=$(php -r 'echo hrtime(true);')

        local elapsed
        elapsed=$(php -r "echo (int)(($end - $start) / 1_000_000);")

        printf "  Run %d: %d ms\n" "$i" "$elapsed"
        total=$((total + elapsed))
        if [ "$elapsed" -lt "$min" ]; then min=$elapsed; fi
        if [ "$elapsed" -gt "$max" ]; then max=$elapsed; fi
    done

    local avg=$((total / RUNS))
    printf "  → min %d ms  max %d ms  avg %d ms\n\n" "$min" "$max" "$avg"
}

echo "PHPStan full-analysis benchmark"
echo "Stub: tests/Rules/stubs/BenchmarkRealistic.php (1000 chains)"
echo "Runs: ${RUNS} cold runs per config"
echo ""

run_config "WITH extension"    "phpstan-benchmark.neon"       ".cache/phpstan-benchmark"
run_config "WITHOUT extension" "phpstan-benchmark-noext.neon" ".cache/phpstan-benchmark-noext"
