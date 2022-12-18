<?php

namespace App\Http\Resources\Test;

use App\Http\Resources\BaseResource;

/**
 * Class TestAnswerResource
 * @package App\Http\Resources\Test
 */
class TestAnswerResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'answer' => $this->answer,
            'is_correct' => $this->is_correct,
            'description' => $this->description,
            'points' => $this->points,
            'created_at' => $this->created_at->toIso8601String(),
        ]);
    }
}
