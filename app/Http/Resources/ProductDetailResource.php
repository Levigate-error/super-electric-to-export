<?php

namespace App\Http\Resources;

class ProductDetailResource extends ProductResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'images' => ProductFileResource::collection($this->images)->resolve(),
            'instructions' => ProductFileResource::collection($this->instructions)->resolve(),
            'videos' => ProductFileResource::collection($this->videos)->resolve(),
            'popular_products' => ProductResource::collection($this->popular_products)->resolve(),
            'recommend_products' => ProductResource::collection($this->recommend_products)->resolve(),
            'category' => ProductCategoryResource::make($this->category)->resolve(),
            'division' => ProductDivisionResource::make($this->division)->resolve(),
            'family' => ProductFamilyResource::make($this->family)->resolve(),
        ]);
    }
}
