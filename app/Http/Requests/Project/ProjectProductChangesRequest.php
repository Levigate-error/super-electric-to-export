<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectProductUpdateRequest
 * @package App\Http\Requests\Project
 */
class ProjectProductChangesRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'change_id' => 'required|exists:project_product_changes,id',
        ];
    }
}
