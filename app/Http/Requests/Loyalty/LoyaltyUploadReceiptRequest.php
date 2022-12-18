<?php

namespace App\Http\Requests\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoyaltyUploadReceiptRequest
 * @package App\Http\Requests\User
 */
class LoyaltyUploadReceiptRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'coupon_code' => 'required|string|min:6|max:30',
            'receipts' => 'required|max:10',
            'receipts.*' => 'mimes:jpeg,jpg,bmp,png,heic,pdf|max:20000',
        ];
    }
}
