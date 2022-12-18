<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Project\ProjectSpecificationProduct;

class ProjectSpecificationProductResource extends BaseResource
{
    /**
     * Товар может быть в спецификации и в каком-то из ее разделов. Или может быть как "нераспределенный". Но данные
     * должны быть с похожей структурой, но с возможностью различать этот момент. Потому такие "красивости"
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        if ($this->resource instanceof ProjectSpecificationProduct) {
            return array_merge(parent::toArray($request), [
                'id' => $this->id,
                'amount' => $this->amount,
                'price' => $this->price,
                'total_price' => $this->total_price,
                'real_price' => $this->real_price,
                'in_stock' => $this->in_stock,
                'active' => $this->active,
                'discount' => $this->discount,
                'product' => ProductResource::make($this->product)->resolve(),
            ]);
        }

        if ($this->resource instanceof Product) {
            $totalPrice = $this->pivot->not_used_amount * $this->pivot->price_with_discount;

            return array_merge(parent::toArray($request), [
                'amount' => $this->pivot->not_used_amount,
                'price' => $this->pivot->price_with_discount,
                'total_price' => number_format($totalPrice, 2, '.', ''),
                'real_price' => $this->pivot->real_price,
                'in_stock' => $this->pivot->in_stock,
                'active' => $this->pivot->active,
                'discount' => $this->pivot->discount,
                'product' => ProductResource::make($this)->resolve(),
            ]);
        }
    }
}
