<?php

namespace App\Http\Resources;

class ProductFileResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'file_link' => $this->file_link,
            'type' => $this->type,
            'description' => $this->description,
            'comment' => $this->comment,
        ];
    }
}
