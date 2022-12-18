<?php

namespace App\Http\Requests\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoyaltyUserRegisterRequest
 * @package App\Http\Requests\Loyalty
 */
class LoyaltyUserRegisterRequest extends FormRequest
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
