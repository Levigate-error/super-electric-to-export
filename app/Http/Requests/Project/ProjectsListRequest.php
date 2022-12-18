<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectsListRequest
 * @package App\Http\Requests\Project
 */
class ProjectsListRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'project_status_id' => 'integer|exists:project_statuses,id',
            'limit' => 'integer',
            'page' => 'integer',
        ];
    }
}
