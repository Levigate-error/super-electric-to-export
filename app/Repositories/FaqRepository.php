<?php

namespace App\Repositories;

use App\Models\Faq;
use App\Domain\Repositories\FaqRepositoryContract;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class FaqRepository
 * @package App\Repositories
 */
class FaqRepository extends BaseRepository implements FaqRepositoryContract
{
    protected $source = Faq::class;

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
