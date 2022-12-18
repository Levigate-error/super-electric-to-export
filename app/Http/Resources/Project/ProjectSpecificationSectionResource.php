<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;

/**
 * Class ProjectSpecificationSectionResource
 * @package App\Http\Resources
 */
class ProjectSpecificationSectionResource extends BaseResource
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
            'discount' => $this->discount,
            'active' => $this->active,
            'products' => !empty($this->sectionProdcuts) ? ProjectSpecificationProductResource::collection($this->sectionProdcuts)->resolve() : [],
        ]);
    }
}
