<?php

namespace App\Utils\Files\Validators\Specification;

use Illuminate\Support\Facades\Validator;

/**
 * Класс для валидации товаров в файле спецификации
 *
 * Class ProductValidator
 * @package App\Utils\Files\Validators\Specification
 */
class ProductValidator
{
    /**
     * @var array
     */
    private $rules = [
        'vendor_code' => 'required|string',
        'name' => 'required|string',
        'amount' => 'required|integer|min:1|max:999',
        'discount' => 'required|integer|min:0|max:100',
        'real_price' => 'required|numeric|min:1',
    ];

    /**
     * @param array $attribute
     * @return array
     */
    public function validate(array $attribute): array
    {
        $validator = Validator::make($attribute, $this->rules);

        return array_keys($validator->errors()->getMessages());
    }
}
