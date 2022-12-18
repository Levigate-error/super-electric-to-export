<?php

namespace App\Models;

/**
 * Class ExternalEntity
 * @package App\Models
 */
class ExternalEntity extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['source_id', 'external_id', 'source_type', 'system'];
}
