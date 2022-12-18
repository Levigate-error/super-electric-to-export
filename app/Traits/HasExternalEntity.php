<?php

namespace App\Traits;

use App\Models\ExternalEntity;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Trait HasExternalEntity
 * @package App\Traits
 */
trait HasExternalEntity
{
    /**
     * @return HasMany
     */
    public function externalEntities(): HasMany
    {
        return $this->hasMany(ExternalEntity::class, 'source_id');
    }

    /**
     * @param string $system
     * @return ExternalEntity|null
     */
    public function externalEntityBySystem(string $system): ?ExternalEntity
    {
        return $this->externalEntities()->where([
            'source_type' => static::class,
            'system' => $system,
        ])->first();
    }
}
