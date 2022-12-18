<?php

namespace App\Domain\Repositories\Test;

use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Test\TestUserTestAnswer;

/**
 * Interface TestUserTestAnswerRepositoryContract
 * @package App\Domain\Repositories\Test
 */
interface TestUserTestAnswerRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return TestUserTestAnswer
     */
    public function store(array $params): TestUserTestAnswer;
}
