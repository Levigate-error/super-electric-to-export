<?php

namespace App\Domain\ServiceContracts\Test;

use App\Collections\Test\TestAnswerCollection;
use App\Domain\Repositories\Test\TestRepositoryContract;

/**
 * Interface TestServiceContract
 * @package App\Domain\ServiceContracts\Test
 */
interface TestServiceContract
{
    /**
     * @return TestRepositoryContract
     */
    public function getRepository(): TestRepositoryContract;

    /**
     * @return array
     */
    public function getTestsForSelect(): array;

    /**
     * @return array
     */
    public function getTests(): array;

    /**
     * @param int $testId
     * @return array
     */
    public function getTest(int $testId): array;

    /**
     * @param int $testId
     * @param int $userId
     * @param array $params
     * @return bool
     */
    public function registerTest(int $testId, int $userId, array $params): bool;

    /**
     * @param int $testId
     * @param array $params
     * @return TestAnswerCollection
     */
    public function prepareTestAnswers(int $testId, array $params): TestAnswerCollection;

    /**
     * @param TestAnswerCollection $testAnswers
     * @return int
     */
    public function getCorrectAnswersPoints(TestAnswerCollection $testAnswers): int;

    /**
     * @param int $testId
     * @param int $userId
     * @return array
     */
    public function getTestResults(int $testId, int $userId): array;
}
