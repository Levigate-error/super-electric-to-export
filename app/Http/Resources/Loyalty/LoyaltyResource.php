<?php

namespace App\Http\Resources\Loyalty;

use App\Http\Resources\BaseResource;

class LoyaltyResource extends BaseResource
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
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'active' => $this->active,
        ]);
    }
}
