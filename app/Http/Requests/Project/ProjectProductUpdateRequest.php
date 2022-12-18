<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectProductUpdateRequest
 * @package App\Http\Requests\Project
 */
class ProjectProductUpdateRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'active' => 'boolean',
            'discount' => 'integer|min:0|max:100',
            'amount' => 'integer|min:1|max:999',
        ];
    }
}
