<?php

namespace App\Collections\Log;

use App\Collections\EloquentTypedCollection as TypedCollection;
use App\Models\Log\CreateLog;

/**
 * Class CreateLogCollection
 * @package App\Collections\Log
 */
class CreateLogCollection extends TypedCollection
{
    /**
     * @var array
     */
    protected static $allowedTypes = [CreateLog::class];
}
