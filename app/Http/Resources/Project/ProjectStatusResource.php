<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;

class ProjectStatusResource extends BaseResource
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
            'slug' => $this->slug,
            'color' => $this->color,
        ]);
    }
}
