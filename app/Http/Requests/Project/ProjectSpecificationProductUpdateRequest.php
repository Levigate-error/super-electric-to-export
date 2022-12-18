<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSpecificationProductUpdateRequest
 * @package App\Http\Requests\Project
 */
class ProjectSpecificationProductUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'active' => 'boolean',
            'discount' => 'integer|min:0|max:100',
            'amount' => 'integer|min:0|max:999',
        ];
    }
}
