<?php

namespace App\Domain\ServiceContracts\Test;

use App\Domain\Repositories\Test\TestQuestionRepositoryContract;

/**
 * Interface TestQuestionServiceContract
 * @package App\Domain\ServiceContracts\Test
 */
interface TestQuestionServiceContract
{
    /**
     * @return TestQuestionRepositoryContract
     */
    public function getRepository(): TestQuestionRepositoryContract;

    /**
     * @return array
     */
    public function getTestQuestionsForSelect(): array;
}
