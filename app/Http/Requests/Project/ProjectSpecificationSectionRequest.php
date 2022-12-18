<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSpecificationSectionRequest
 * @package App\Http\Requests\Project
 */
class ProjectSpecificationSectionRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
        ];
    }
}
