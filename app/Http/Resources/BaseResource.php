<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BaseResource
 * @package App\Http\Resources
 */
class BaseResource extends JsonResource
{
    /**
     * @return bool
     */
    protected function isTranslatable(): bool
    {
        if (!$this->resource) {
            return false;
        }

        return in_array("App\Traits\Translatable", class_uses($this->resource), true);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        if ($this->isTranslatable()) {
            $this->resource->translate($this->resource);
        }

        return [];
    }
}
