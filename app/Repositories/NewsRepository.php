<?php

namespace App\Repositories;

use App\Models\News;
use App\Domain\Repositories\NewsRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class NewsRepository
 * @package App\Repositories
 */
class NewsRepository extends BaseRepository implements NewsRepositoryContract
{
    protected $source = News::class;

    /**
     * @param array $params
     * @return LengthAwarePaginator
     */
    public function getByParams(array $params = []): LengthAwarePaginator
    {
        $query = $this->getQueryBuilder()
            ->published()
            ->orderByDesc('id');

        if (isset($params['limit']) === true) {
            $limit = $this->prepareLimit($params['limit']);

            return $query->paginate($limit);
        }

        return $query->paginate();
    }
}
