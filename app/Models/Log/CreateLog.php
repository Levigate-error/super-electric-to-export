<?php

namespace App\Models\Log;

use App\Collections\Log\CreateLogCollection;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class CreateLog
 * @package App\Models\Log
 */
class CreateLog extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['ip', 'client', 'logable_id', 'logable_type'];

    /**
     * @param array $models
     * @return CreateLogCollection
     */
    public function newCollection(array $models = []): CreateLogCollection
    {
        return new CreateLogCollection($models);
    }

    /**
     * @return MorphTo
     */
    public function logable(): MorphTo
    {
        return $this->morphTo();
    }
}
