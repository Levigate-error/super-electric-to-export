<?php

namespace App\Http\Resources;

class ProductDivisionResource extends BaseResource
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
            'product_amount' => isset($this->product_amount) ? $this->product_amount : 0,
            'image' => $this->imagePath,
        ]);
    }
}
