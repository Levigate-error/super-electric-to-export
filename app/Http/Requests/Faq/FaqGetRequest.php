<?php

namespace App\Http\Requests\Faq;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class FaqGetRequest
 * @package App\Http\Requests\Faq
 */
class FaqGetRequest extends FormRequest
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
