<?php

namespace App\Http\Resources\Test;

use App\Http\Resources\BaseResource;

/**
 * Class TestResultResource
 * @package App\Http\Resources\Test
 */
class TestResultResource extends BaseResource
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
            'description' => $this->description,
            'percent_from' => $this->percent_from,
            'percent_to' => $this->percent_to,
            'image' => $this->imagePath,
            'created_at' => $this->created_at->toIso8601String(),
        ]);
    }
}
