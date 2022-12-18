<?php

namespace App\Http\Resources;

class ProductFeatureValueResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'value' => $this->value,
            'product_count' => $this->product_count,
        ];
    }
}
