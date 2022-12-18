<?php

namespace App\Http\Resources\Video;

use App\Http\Resources\BaseResource;

/**
 * Class VideoCategoryResource
 * @package App\Http\Resources\Video
 */
class VideoCategoryResource extends BaseResource
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
            'created_at' => $this->created_at,
        ]);
    }
}
