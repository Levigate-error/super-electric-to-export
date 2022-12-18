<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectCategoryRequest
 * @package App\Http\Requests\Project
 */
class ProjectCategoryRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_category' => 'required|exists:product_categories,id',
        ];
    }
}
