<?php

namespace App\Repositories;

use App\Models\Analogue;
use App\Domain\Repositories\AnalogueRepository;
use App\Collections\AnalogCollection;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AnalogueEloquentRepository
 * @package App\Repositories
 */
class AnalogueEloquentRepository extends BaseRepository implements AnalogueRepository
{
    protected $source = Analogue::class;

    /**
     * @param array $params
     * @return AnalogCollection
     */
    public function getAnalogsByParams(array $params): AnalogCollection
    {
        return $this->getQueryWithParams($params)->get();
    }

    /**
     * @param array $params
     * @return Analogue|null
     */
    public function getFirstAnalogByParams(array $params): ?Analogue
    {
        return $this->getQueryWithParams($params)->first();
    }

    /**
     * @param array $params
     * @return Builder
     */
    protected function getQueryWithParams(array $params): Builder
    {
        $query = $this->getQueryBuilder()->with('products');

        return $query->where($params);
    }
}
