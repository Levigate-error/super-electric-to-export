<?php

namespace App\Http\Requests\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoyaltyRegisterProductCodeRequest
 * @package App\Http\Requests\Loyalty
 */
class LoyaltyRegisterProductCodeRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string',
            'loyalty_id' => 'required|integer|exists:loyalties,id',
        ];
    }
}
