<?php

namespace App\Domain\Repositories\Test;

use App\Collections\Test\TestResultCollection;
use App\Domain\Repositories\MustHaveGetSource;
use App\Models\Test\TestResult;

/**
 * Interface TestResultRepositoryContract
 * @package App\Domain\Repositories\Test
 */
interface TestResultRepositoryContract extends MustHaveGetSource
{
    /**
     * Поиск пересечения диапазонов процентов от и до
     *
     * @param int $testId
     * @param int $percentFrom
     * @param int $percentTo
     * @param int|null $testResultId
     * @return TestResultCollection|null
     */
    public function getIntersectionResults(int $testId, int $percentFrom, int $percentTo, ?int $testResultId = null): ?TestResultCollection;

    /**
     * @param int $testId
     * @param int $percent
     * @return TestResult|null
     */
    public function getTestResultByPercent(int $testId, int $percent): ?TestResult;
}
