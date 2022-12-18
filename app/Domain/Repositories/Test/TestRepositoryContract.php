<?php

namespace App\Domain\Repositories\Test;

use App\Collections\Test\TestCollection;
use App\Domain\Repositories\MustHaveGetSource;

/**
 * Interface TestRepositoryContract
 * @package App\Domain\Repositories\Test
 */
interface TestRepositoryContract extends MustHaveGetSource
{
    /**
     * @param array $params
     * @return TestCollection
     */
    public function getByParams(array $params = []): TestCollection;

    /**
     * @param int $testId
     * @return int
     */
    public function getMaxPoints(int $testId): int;
}
