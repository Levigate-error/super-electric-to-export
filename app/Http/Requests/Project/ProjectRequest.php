<?php

namespace App\Http\Requests\Project;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProjectRequest
 * @package App\Http\Requests\Project
 */
class ProjectRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => 'string',
            'address' => 'string',
            'project_status_id' => 'integer|exists:project_statuses,id',
            'user_id' => 'integer|exists:users,id',
            'contacts.*.*' => 'string',
            'attributes.*' => 'integer|exists:project_attribute_values,id',
        ];
    }

    /**
     * Если авторизованный пользователь, то цепляем его ID
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function prepareForValidation()
    {
        if ($user = app()->make(Authenticatable::class)) {
            $this->merge(['user_id' => $user->getAuthIdentifier()]);
        }
    }
}
