<?php

namespace App\Repositories;

use App\Collections\CityCollection;
use App\Models\City;
use App\Domain\Repositories\CityRepositoryContract;

/**
 * Class CityRepository
 * @package App\Repositories
 */
class CityRepository extends BaseRepository implements CityRepositoryContract
{
    protected $source = City::class;

    /**
     * @param array $params
     * @return CityCollection
     */
    public function getCitiesByParams(array $params): CityCollection
    {
        $locale = get_current_local();
        $query = $this->getQueryBuilder();

        if (isset($params['title'])) {
            $query->where("title->$locale", 'ILIKE', "%{$params['title']}%");
        }

        return $query->get();
    }
}
