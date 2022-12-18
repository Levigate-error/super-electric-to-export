<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;

/**
 * Class ProjectProductUpdateResource
 * @package App\Http\Resources\Project
 */
class ProjectProductUpdateResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'vendor_code' => $this->vendor_code,
            'name' => $this->name,
            'old_value' => $this->old_value,
            'new_value' => $this->new_value,
            'type' => $this->type,
            'typeOnHuman' => $this->typeOnHuman,
            'used' => $this->used,
        ]);
    }
}
