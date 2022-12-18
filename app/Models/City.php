<?php

namespace App\Models;

use App\Collections\CityCollection;
use App\Traits\Translatable;

/**
 * Class City
 * @package App\Models
 */
class City extends BaseModel
{
    use Translatable;

    /**
     * @var array
     */
    protected $translatableFields = ['title'];

    /**
     * @var array
     */
    protected $fillable = ['title'];

    /**
     * @param array $models
     * @return CityCollection
     */
    public function newCollection(array $models = []): CityCollection
    {
        return new CityCollection($models);
    }
}
