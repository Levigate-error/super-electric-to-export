<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSpecificationProductReplaceRequest
 * @package App\Http\Requests\Project
 */
class ProjectSpecificationProductReplaceRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'specification_product' => 'required|integer|exists:project_specification_products,id',
            'amount' => 'required|integer|min:1|max:999',
            'section_from' => 'required|integer|exists:project_specification_sections,id',
            'section_to' => 'required|integer|exists:project_specification_sections,id',
        ];
    }
}
