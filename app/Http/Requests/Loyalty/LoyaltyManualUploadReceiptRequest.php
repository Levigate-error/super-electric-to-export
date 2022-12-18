<?php

namespace App\Http\Requests\Loyalty;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoyaltyManualUploadReceiptRequest
 * @package App\Http\Requests\User
 */
class LoyaltyManualUploadReceiptRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'receipt_datetime' => 'required|date-format:d.m.y H:i',
            'fn' => 'required|string',
            'fd' => 'required|string',
            'fp' => 'required|string',
            'amount' => 'required|numeric|gt:0',
            'coupon_code' => 'required|string|min:6|max:30',
        ];
    }

    public function messages(){
        return [
            'receipt_datetime.required' => 'Поле Дата и время покупки обязательное.',
            'receipt_datetime.date-format' => 'Неверный формат даты и времени покупки',
            'fn.required' => 'Поле ФН обязательное.',
            'fd.required' => 'Поле ФД обязательное.',
            'fp.required' => 'Поле ФП обязательное.',
            'amount.required' => 'Поле Сумма покупки обязательное.',
            'amount.gt' => 'Поле Сумма покупкидолжно быть больше 0.',
        ];
    }
}
