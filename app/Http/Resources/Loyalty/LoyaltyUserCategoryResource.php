<?php

namespace App\Http\Resources\Loyalty;

use App\Http\Resources\BaseResource;

/**
 * Class LoyaltyUserCategoryResource
 * @package App\Http\Resources\Loyalty
 */
class LoyaltyUserCategoryResource extends BaseResource
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
            'icon' => $this->icon,
            'icon_with_path' => $this->iconWithPath,
            'points' => $this->points,
        ]);
    }
}
