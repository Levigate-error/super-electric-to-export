<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;

class ProjectContactResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
        ]);
    }
}
