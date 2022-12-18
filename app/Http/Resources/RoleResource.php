<?php

namespace App\Http\Resources;

/**
 * Class RoleResource
 * @package App\Http\Resources
 */
class RoleResource extends BaseResource
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
            'slug' => $this->slug,
            'description' => $this->description,
        ]);
    }
}
