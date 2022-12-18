<?php

namespace App\Services\Test;

use App\Services\BaseService;
use App\Domain\ServiceContracts\Test\TestServiceContract;
use App\Domain\Repositories\Test\TestRepositoryContract;
use App\Http\Resources\Test\TestResource;
use App\Domain\Repositories\Test\TestAnswerRepositoryContract;
use App\Domain\Repositories\Test\TestUserRepositoryContract;
use App\Domain\Repositories\Test\TestResultRepositoryContract;
use Illuminate\Support\Facades\DB;
use App\Collections\Test\TestAnswerCollection;
use App\Http\Resources\Test\TestResultResource;

/**
 * Class TestService
 * @package App\Services\Test
 */
class TestService extends BaseService implements TestServiceContract
{
    /**
     * @var TestRepositoryContract
     */
    private $repository;

    /**
     * TestService constructor.
     * @param TestRepositoryContract $repository
     */
    public function __construct(TestRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return TestRepositoryContract
     */
    public function getRepository(): TestRepositoryContract
    {
        return $this->repository;
    }

    /**
     * @return array
     */
    public function getTestsForSelect(): array
    {
        return $this->repository
            ->getByParams()
            ->untype()
            ->pluck('title', 'id')
            ->toArray();
    }

    /**
     * @return array
     */
    public function getTests(): array
    {
        $tests = $this->repository->getByParams(['published' => true]);

        return TestResource::collection($tests->untype())->resolve();
    }

    /**
     * @param int $testId
     * @return array
     */
    public function getTest(int $testId): array
    {
        $test = $this->repository->getById($testId);

        return TestResource::make($test)->resolve();
    }

    /**
     * @param int $testId
     * @param int $userId
     * @param array $params
     * @return bool
     */
    public function registerTest(int $testId, int $userId, array $params): bool
    {
        $testUserRepository = app(TestUserRepositoryContract::class);
        $testResultRepository = app(TestResultRepositoryContract::class);

        $test = $this->getTest($testId);

        DB::beginTransaction();

        $testUser = $testUserRepository->store([
            'user_id' => $userId,
            'test_id' => $test['id'],
            'points' => 0,
        ]);

        $preparedTestAnswers = $this->prepareTestAnswers($test['id'], $params);
        $answerIds = $preparedTestAnswers
            ->pluck('id')
            ->toArray();
        $testUser = $testUserRepository->storeUserAnswers($testUser, $answerIds);

        $points = $this->getCorrectAnswersPoints($testUser->userTestAnswers);
        $maxPoints = $this->repository->getMaxPoints($test['id']);
        $percentOfCorrectAnswer = (int)((100 / $maxPoints) * $points);

        $testResult = $testResultRepository->getTestResultByPercent($test['id'], $percentOfCorrectAnswer);

        $testUserParams = [
            'points' => $points,
            'max_points' => $maxPoints,
        ];

        if ($testResult !== null) {
            $testUserParams['test_result_id'] = $testResult->id;
        }

        $testUserRepository->update($testUser, $testUserParams);

        DB::commit();

        return true;
    }

    /**
     * @param TestAnswerCollection $testAnswers
     * @return int
     */
    public function getCorrectAnswersPoints(TestAnswerCollection $testAnswers): int
    {
        return $testAnswers->sum(static function ($answer) {
            return $answer->is_correct === true ? $answer->points : 0;
        });
    }

    /**
     * Подготовка данных. Собираем только ответы, относящиеся к вопросу, и вопросы, относящиеся к тесту.
     *
     * @param int $testId
     * @param array $params
     * @return TestAnswerCollection
     */
    public function prepareTestAnswers(int $testId, array $params): TestAnswerCollection
    {
        if (!isset($params['questions'])) {
            return [];
        }

        $testAnswerRepository = app(TestAnswerRepositoryContract::class);

        $testQuestions = [];
        $testAnswers = [];
        foreach ($params['questions'] as $question) {
            $testQuestions[] = $question['id'];

            if (!isset($question['answers'])) {
                return [];
            }

            foreach ($question['answers'] as $answer) {
                $testAnswers[] = $answer['id'];
            }
        }

        $testAnswers = $testAnswerRepository->getByParams([
            'test_id' => $testId,
            'test_question_ids' => $testQuestions,
            'test_answer_ids' => $testAnswers,
        ]);

        return $testAnswers;
    }

    /**
     * @param int $testId
     * @param int $userId
     * @return array
     */
    public function getTestResults(int $testId, int $userId): array
    {
        $testUserRepository = app(TestUserRepositoryContract::class);

        $testUser = $testUserRepository->getLastByParams([
            'user_id' => $userId,
            'test_id' => $testId,
        ]);

        return [
            'test' => $this->getTest($testId),
            'result' => ($testUser->testResult !== null)
                ? TestResultResource::make($testUser->testResult)->resolve()
                : [],
            'points_result' => [
                'message' => trans('test.test_result', [
                    'points' => $testUser->points,
                    'maxPoints' => $testUser->max_points,
                ]),
                'points' => $testUser->points,
                'maxPoints' => $testUser->max_points,
            ],
        ];

    }
}
