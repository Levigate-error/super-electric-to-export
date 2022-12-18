<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectProductsSearchRequest
 * @package App\Http\Requests\Project
 */
class ProjectProductsSearchRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'search' => 'string',
        ];
    }
}
