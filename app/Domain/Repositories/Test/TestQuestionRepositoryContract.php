<?php

namespace App\Domain\Repositories\Test;

use App\Collections\Test\TestQuestionCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface TestQuestionRepositoryContract
 * @package App\Domain\Repositories\Test
 */
interface TestQuestionRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return TestQuestionCollection
     */
    public function getByParams(array $params = []): TestQuestionCollection;
}
