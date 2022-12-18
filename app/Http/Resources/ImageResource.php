<?php

namespace App\Http\Resources;

/**
 * Class ImageResource
 * @package App\Http\Resources
 */
class ImageResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'size' => $this->size,
            'path' => $this->image_path,
        ]);
    }
}
