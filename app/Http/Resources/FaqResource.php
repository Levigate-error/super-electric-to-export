<?php

namespace App\Http\Resources;

/**
 * Class FaqResource
 * @package App\Http\Resources
 */
class FaqResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'question' => $this->question,
            'answer' => $this->answer,
            'created_at' => $this->created_at->toIso8601String(),
        ]);
    }
}
