<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;

/**
 * Class ProjectSpecificationResource
 * @package App\Http\Resources
 */
class ProjectSpecificationResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        if (is_null($this->resource)) {
            return [];
        }

        return [
            'id' => $this->id,
            'version' => $this->version,
        ];
    }
}
