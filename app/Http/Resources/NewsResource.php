<?php

namespace App\Http\Resources;

/**
 * Class NewsResource
 * @package App\Http\Resources
 */
class NewsResource extends BaseResource
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
            'short_description' => $this->short_description,
            'description' => $this->description,
            'image' => $this->imagePath,
            'style' => 'background-image: url(' . $this->imagePath . ')',
            'created_at' => $this->created_at->toIso8601String(),
        ]);
    }
}
