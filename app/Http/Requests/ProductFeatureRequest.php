<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFeatureRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'integer|exists:product_categories,id',
            'family' => 'integer|exists:product_families,id',
            'division' => 'integer|exists:product_divisions,id',
        ];
    }
}
