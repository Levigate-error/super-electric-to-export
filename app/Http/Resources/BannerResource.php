<?php

namespace App\Http\Resources;

/**
 * Class BannerResource
 * @package App\Http\Resources
 */
class BannerResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'images' => ImageResource::collection($this->images)->resolve(),
        ]);
    }
}
