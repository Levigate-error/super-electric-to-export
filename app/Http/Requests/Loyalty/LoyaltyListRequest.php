<?php

namespace App\Http\Requests\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoyaltyListRequest
 * @package App\Http\Requests\Loyalty
 */
class LoyaltyListRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'active' => 'boolean',
        ];
    }
}
