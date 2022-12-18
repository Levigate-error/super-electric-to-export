<?php

namespace App\Domain\Repositories\Test;

use App\Collections\Test\TestAnswerCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface TestAnswerRepositoryContract
 * @package App\Domain\Repositories\Test
 */
interface TestAnswerRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return TestAnswerCollection
     */
    public function getByParams(array $params): TestAnswerCollection;
}
