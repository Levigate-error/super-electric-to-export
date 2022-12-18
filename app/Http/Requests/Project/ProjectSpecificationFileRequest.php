<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectSpecificationFileRequest
 * @package App\Http\Requests\Project
 */
class ProjectSpecificationFileRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => 'required|file|max:2048|mimes:xlsx',
        ];
    }
}
