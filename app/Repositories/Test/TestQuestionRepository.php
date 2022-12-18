<?php

namespace App\Repositories\Test;

use App\Collections\Test\TestQuestionCollection;
use App\Repositories\BaseRepository;
use App\Models\Test\TestQuestion;
use App\Domain\Repositories\Test\TestQuestionRepositoryContract;

/**
 * Class TestQuestionRepository
 * @package App\Repositories\Test
 */
class TestQuestionRepository extends BaseRepository implements TestQuestionRepositoryContract
{
    protected $source = TestQuestion::class;

    /**
     * @param array $params
     * @return TestQuestionCollection
     */
    public function getByParams(array $params = []): TestQuestionCollection
    {
        $query = $this->getQueryBuilder();

        if (isset($params['published']) === true) {
            $query->published($params['published']);
            unset($params['published']);
        }

        return $query
            ->where($params)
            ->orderBy('id')
            ->get();
    }
}
