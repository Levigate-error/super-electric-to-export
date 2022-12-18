<?php

namespace App\Repositories\Log;

use App\Repositories\BaseRepository;
use App\Models\Log\CreateLog;
use App\Domain\Repositories\Log\CreateLogRepositoryContract;
use App\Collections\Log\CreateLogCollection;

/**
 * Class CreateLogRepository
 * @package App\Repositories\Log
 */
class CreateLogRepository extends BaseRepository implements CreateLogRepositoryContract
{
    /**
     * @var string
     */
    protected $source = CreateLog::class;

    /**
     * @param array $params
     * @return CreateLogCollection
     */
    public function getByParams(array $params = []): CreateLogCollection
    {
        $query = $this->getQueryBuilder()
            ->orderByDesc('id');

        if (isset($params['client']) === true) {
            $query->where([
                'client' => $params['client'],
            ]);
        }

        if (isset($params['type']) === true) {
            $query->where([
                'logable_type' => $params['type'],
            ]);
        }

        if (isset($params['dateFrom']) === false) {
            $params['dateFrom'] = now()->addHours(-24);
        }

        $query->where('created_at', '>=', $params['dateFrom']);

        return $query->get();
    }
}
