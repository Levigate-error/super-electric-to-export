<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSpecificationProductRequest
 * @package App\Http\Requests\Project
 */
class ProjectSpecificationProductRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'product' => 'required|integer|exists:products,id',
            'section' => 'required|integer|exists:project_specification_sections,id',
            'amount' => 'required|integer|min:1|max:999',
        ];
    }
}
