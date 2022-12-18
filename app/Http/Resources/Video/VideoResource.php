<?php

namespace App\Http\Resources\Video;

use App\Http\Resources\BaseResource;

/**
 * Class VideoResource
 * @package App\Http\Resources\Video
 */
class VideoResource extends BaseResource
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
            'video' => $this->video,
            'created_at' => $this->created_at,
            'video_category' => VideoCategoryResource::make($this->videoCategory)->resolve(),
        ]);
    }
}
