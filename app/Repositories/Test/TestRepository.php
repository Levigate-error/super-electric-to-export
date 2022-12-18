<?php

namespace App\Repositories\Test;

use App\Collections\Test\TestCollection;
use App\Repositories\BaseRepository;
use App\Models\Test\Test;
use App\Domain\Repositories\Test\TestRepositoryContract;

/**
 * Class TestRepository
 * @package App\Repositories\Test
 */
class TestRepository extends BaseRepository implements TestRepositoryContract
{
    protected $source = Test::class;

    /**
     * @param array $params
     * @return TestCollection
     */
    public function getByParams(array $params = []): TestCollection
    {
        $query = $this->getQueryBuilder();

        if (isset($params['published']) === true) {
            $query->published($params['published']);
            unset($params['published']);
        }

        return $query
            ->where($params)
            ->orderBy('title')
            ->get();
    }

    /**
     * @param int $testId
     * @return int
     */
    public function getMaxPoints(int $testId): int
    {
        return $this->getQueryBuilder()
            ->leftJoin('test_questions', 'test_questions.test_id', '=', 'tests.id')
            ->leftJoin('test_answers', 'test_answers.test_question_id', '=', 'test_questions.id')
            ->where('tests.id', $testId)
            ->where('test_answers.is_correct', true)
            ->sum('test_answers.points');
    }
}
