<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Collections\AnalogCollection;
use App\Traits\Translatable;

/**
 * Class Analogue
 * @package App\Models
 */
class Analogue extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $translatableFields = ['description'];

    /**
     * @var array
     */
    protected $fillable = ['vendor_code', 'description', 'vendor'];

    /**
     * @param array $models
     * @return AnalogCollection
     */
    public function newCollection(array $models = []): AnalogCollection
    {
        return new AnalogCollection($models);
    }

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
