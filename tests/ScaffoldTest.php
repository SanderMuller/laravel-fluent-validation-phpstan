<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use SanderMuller\LaravelFluentValidationPhpstan\Traits\ChecksNamespace;

final class ScaffoldTest extends TestCase
{
    #[Test]
    public function checks_namespace_trait_exists(): void
    {
        $this->assertTrue(trait_exists(ChecksNamespace::class));
    }
}
