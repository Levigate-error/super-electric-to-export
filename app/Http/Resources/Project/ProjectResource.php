<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;

class ProjectResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'address' => $this->address,
            'total_price' => $this->total_price,
            'updated_at' => $this->updated_at,
            'status' => !empty($this->status) ? ProjectStatusResource::make($this->status)->resolve() : [],
            'contacts' => ProjectContactResource::collection($this->contacts)->resolve(),
            'attributes' => ProjectAttributeProjectResource::collection($this->projectsAttributes)->resolve(),
        ];
    }
}
