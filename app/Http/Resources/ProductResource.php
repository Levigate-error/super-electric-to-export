<?php

namespace App\Http\Resources;

class ProductResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'vendor_code' => $this->vendor_code,
            'recommended_retail_price' => $this->recommended_retail_price,
            'min_amount' => $this->min_amount,
            'unit' => $this->unit,
            'img' => $this->main_image,
            'is_favorites' => $this->is_favorites,
            'attributes' => $this->attributes ?? [],
            'amount' => $this->amount ?? 0,
            'real_price' => $this->real_price ?? 0,
            'in_stock' => $this->in_stock ?? true,
            'discount' => $this->discount ?? 0,
            'price_with_discount' => $this->price_with_discount ?? 0,
            'rank' => $this->rank ?? 0,
        ]);
    }
}
