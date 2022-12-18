<?php

namespace App\Http\Resources;

/**
 * Class FeedbackResource
 * @package App\Http\Resources
 */
class FeedbackResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'text' => $this->text,
            'status' => $this->statusOnHuman,
            'file_url' => $this->fileUrl,
            'type' => $this->typeOnHuman,
        ]);
    }
}
