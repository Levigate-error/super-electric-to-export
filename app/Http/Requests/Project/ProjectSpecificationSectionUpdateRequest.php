<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSpecificationSectionUpdateRequest
 * @package App\Http\Requests\Project
 */
class ProjectSpecificationSectionUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'string',
            'discount' => 'integer|min:0|max:100',
            'active' => 'boolean',
        ];
    }
}
