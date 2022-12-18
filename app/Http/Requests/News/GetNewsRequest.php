<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GetNewsRequest
 * @package App\Http\Requests\News
 */
class GetNewsRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'limit' => 'integer',
            'page' => 'integer',
        ];
    }
}
