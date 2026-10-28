<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

final class NamedStaticTarget extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['name' => $rules->string()->required()]);
    }
}

/**
 * A class-named static call from an unrelated scope must resolve against the
 * named class, not the enclosing one — the enclosing class here has no
 * `schema()` at all, so answering from the scope would narrow to `array{}`.
 */
final class UnrelatedStaticCall extends FormRequest
{
    use HasFluentRules;

    public function describe(): void
    {
        assertType(RuleSet::class, NamedStaticTarget::rules());
    }
}
