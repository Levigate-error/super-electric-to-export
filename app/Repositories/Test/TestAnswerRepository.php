<?php

namespace App\Repositories\Test;

use App\Repositories\BaseRepository;
use App\Models\Test\TestAnswer;
use App\Domain\Repositories\Test\TestAnswerRepositoryContract;
use Illuminate\Database\Eloquent\Builder;
use App\Collections\Test\TestAnswerCollection;

/**
 * Class TestAnswerRepository
 * @package App\Repositories\Test
 */
class TestAnswerRepository extends BaseRepository implements TestAnswerRepositoryContract
{
    protected $source = TestAnswer::class;

    /**
     * @param array $params
     * @return TestAnswerCollection
     */
    public function getByParams(array $params): TestAnswerCollection
    {
        $query = $this->getQueryBuilder();

        if ($this->isAnswerForTestResults($params) === true) {
            $query
                ->whereIn('id', $params['test_answer_ids'])
                ->whereHas('testQuestion', static function (Builder $testQuestionBuilder) use ($params) {
                    $testQuestionBuilder
                        ->whereIn('test_questions.id', $params['test_question_ids'])
                        ->where('test_questions.test_id', $params['test_id']);

                    return $testQuestionBuilder;
                });
        }

        return $query->get();
    }

    /**
     * Запрос ответов, входящих в вопросы теста
     *
     * @param array $params
     * @return bool
     */
    protected function isAnswerForTestResults(array $params): bool
    {
        return (isset($params['test_id']) === true) &&
            (isset($params['test_question_ids']) === true) &&
            (isset($params['test_answer_ids']) === true);
    }
}
