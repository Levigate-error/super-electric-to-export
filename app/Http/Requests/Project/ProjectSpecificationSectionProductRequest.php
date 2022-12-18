<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSpecificationSectionProductRequest
 * @package App\Http\Requests\Project
 */
class ProjectSpecificationSectionProductRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'product' => 'required|exists:products,id',
            'amount' => 'integer|min:1|max:999',
        ];
    }
}
