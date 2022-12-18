<?php

namespace App\Traits;

use App\Models\Log\CreateLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait HasCreateLog
 * @package App\Traits
 */
trait HasCreateLog
{
    /**
     * @return MorphMany
     */
    public function createLogs(): morphMany
    {
        return $this->morphMany(CreateLog::class, 'logable');
    }
}
