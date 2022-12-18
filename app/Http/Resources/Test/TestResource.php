<?php

namespace App\Http\Resources\Test;

use App\Http\Resources\BaseResource;

/**
 * Class TestResource
 * @package App\Http\Resources\Test
 */
class TestResource extends BaseResource
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
            'image' => $this->imagePath,
            'description' => $this->description,
            'questions' => !empty($this->testQuestions)
                ? TestQuestionResource::collection($this->testQuestions()->published()->get()->untype())->resolve()
                : [],
            'created_at' => $this->created_at->toIso8601String(),
        ]);
    }
}
