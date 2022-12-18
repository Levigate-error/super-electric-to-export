<?php

namespace App\Http\Requests\Test;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterTestRequest
 * @package App\Http\Requests\Test
 */
class RegisterTestRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'questions' => 'required|array',
            'questions.*.answers' => 'required|array',
        ];
    }
}
