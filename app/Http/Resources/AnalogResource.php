<?php

namespace App\Http\Resources;

class AnalogResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'vendor' => $this->vendor,
            'vendor_code' => $this->vendor_code,
            'description' => $this->description,
            'products' => !empty($this->products) ? ProductResource::collection($this->products)->resolve() : [],
        ]);
    }
}
