<?php

namespace App\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UploadFileRequest
 * @package App\Admin\Requests
 */
class UploadFileRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'upload' => 'required|file|mimes:jpeg,jpg,png',
        ];
    }
}
