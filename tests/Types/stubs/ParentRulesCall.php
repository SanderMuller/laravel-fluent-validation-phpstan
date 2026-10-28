<?php declare(strict_types=1);

namespace SanderMuller\LaravelFluentValidationPhpstan\Tests\Types\stubs;

use Illuminate\Foundation\Http\FormRequest;
use SanderMuller\FluentValidation\FluentSchema;
use SanderMuller\FluentValidation\HasFluentRules;
use SanderMuller\FluentValidation\RuleSet;

use function PHPStan\Testing\assertType;

abstract class BaseParentRulesRequest extends FormRequest
{
    use HasFluentRules;

    public function schema(FluentSchema $rules): RuleSet
    {
        return RuleSet::from(['video_id' => $rules->string()->required()]);
    }
}

/**
 * The `SessionStartedRequest` shape: the parent declares only `schema()`, the
 * child extends it through `parent::rules()`.
 */
final class ParentRulesCall extends BaseParentRulesRequest
{
    public function rules(): RuleSet
    {
        assertType(RuleSet::class, parent::rules());

        return parent::rules()->merge(['position' => $this->schema(new FluentSchema())]);
    }
}
