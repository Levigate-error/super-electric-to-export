<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;

/**
 * Class UserActivityResource
 * @package App\Http\Resources\User
 */
class UserActivityResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'source_id' => $this->source_id,
            'source_type' => $this->source_type,
            'title' => $this->title,
        ]);
    }
}
