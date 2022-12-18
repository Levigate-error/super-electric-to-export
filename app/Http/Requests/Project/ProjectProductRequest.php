<?php

namespace App\Http\Requests\Project;

use App\Domain\ServiceContracts\Project\ProjectServiceContract;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ProjectProductRule;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class ProjectProductRequest
 * @package App\Http\Requests\Project
 */
class ProjectProductRequest extends FormRequest
{
    /**
     * @return array
     * @throws BindingResolutionException
     */
    public function rules(): array
    {
        return [
            'product' => 'required|exists:products,id',
            'projects' => ['required', new ProjectProductRule(app()->make(ProjectServiceContract::class))],
        ];
    }
}
