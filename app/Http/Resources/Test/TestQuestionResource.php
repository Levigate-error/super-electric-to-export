<?php

namespace App\Http\Resources\Test;

use App\Http\Resources\BaseResource;

/**
 * Class TestQuestionResource
 * @package App\Http\Resources\Test
 */
class TestQuestionResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'test_id' => $this->test_id,
            'question' => $this->question,
            'image' => $this->imagePath,
            'video' => $this->video,
            'answers' => !empty($this->testAnswers)
                ? TestAnswerResource::collection($this->testAnswers()->published()->get()->untype())->resolve()
                : [],
            'created_at' => $this->created_at->toIso8601String(),
        ]);
    }
}
