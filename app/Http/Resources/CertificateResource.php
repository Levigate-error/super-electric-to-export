<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseResource;

class CertificateResource extends BaseResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return array_merge(parent::toArray($request), [
            'id' => $this->id,
            'code' => $this->code,
            'active' => $this->active,
        ]);
    }
}
