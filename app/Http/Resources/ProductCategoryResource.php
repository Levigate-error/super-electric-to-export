<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Log;

class ProductCategoryResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->imagePath,
        ]);
    }
}
