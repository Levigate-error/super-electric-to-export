<?php

namespace App\Http\Resources;

/**
 * Class CityResource
 * @package App\Http\Resources
 */
class CityResource extends BaseResource
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
        ]);
    }
}
