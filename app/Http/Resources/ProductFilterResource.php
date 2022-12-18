<?php

namespace App\Http\Resources;

class ProductFilterResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $featureValues = sort_by_first_element($this->values, 'value');

        return [
            'id' => $this->id,
            'name' => $this->name,
            'values' => ProductFeatureValueResource::collection($featureValues)->resolve(),
        ];
    }
}
