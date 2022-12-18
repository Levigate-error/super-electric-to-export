<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;

/**
 * Class ProductRequest
 * @package App\Http\Requests
 */
class ProductRequest extends FormRequest
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
            'filter_values' => 'array',
            'price_from' => 'integer',
            'price_to' => 'integer',
            'limit' => 'integer',
            'page' => 'integer',
            'search' => 'string',
            'favorite' => 'boolean',
            'favorite_user_id' => 'integer|exists:users,id',
            'sort_column' => [
                'string',
                static function ($attribute, $value, $fail) {
                    if (Schema::hasColumn('products', $value) === false) {
                        $attributeTrans = trans("validation.attributes.$attribute");
                        $message = trans('validation.exists', ['attribute' => $attributeTrans]);

                        $fail($message);
                    }
                },
            ],
            'sort_type' => 'in:asc,desc',
            'is_loyalty' => 'boolean',
        ];
    }

    /**
     * Мутируем параметры.
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function prepareForValidation()
    {
        if ($this->get('favorite') && $user = app()->make(Authenticatable::class)) {
            $this->merge(['favorite_user_id' => $user->getAuthIdentifier()]);
        }

        if (!$this->get('limit')) {
            $this->merge(['limit' => 18]);
        }
    }
}
