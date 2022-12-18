<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserPersonalDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'passport_series' => 'required|string',
            'passport_number' => 'required|string',
            'issuer' => 'required|string',
            'issuer_code' => 'required|string',
            'registration_address' => 'required|string',
            'issue_date' => 'required|date_format:Y-m-d',
            'taxpayer_number' => 'required|string',
            'spread_photo' => 'required|mimes:jpeg,jpg,bmp,png,heic,pdf|max:20000',
            'registration_photo' => 'required|mimes:jpeg,jpg,bmp,png,heic,pdf|max:20000',
            'tax_certificate_photo' => 'required|mimes:jpeg,jpg,bmp,png,heic,pdf|max:20000'
        ];
    }
}
