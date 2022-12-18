<?php

namespace App\Repositories;

use App\Traits\HasSourceGetter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\BaseModel;

/**
 * Class BaseRepository
 * @package App\Repositories
 */
class BaseRepository
{
    use HasSourceGetter;

    /**
     * @return Builder
     */
    protected function getQueryBuilder(): Builder
    {
        return $this->getSource()::query();
    }

    /**
     * @param int $id
     * @return BaseModel
     */
    public function getById(int $id): BaseModel
    {
        return $this->getQueryBuilder()->findOrFail($id);
    }

    /**
     * @param int $limit
     * @return int
     */
    protected function prepareLimit(int $limit): int
    {
        $max = config('pagination.page_items_limit');

        return ($max > $limit) ? $limit : $max;
    }
}
