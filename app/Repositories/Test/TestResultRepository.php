<?php

namespace App\Repositories\Test;

use App\Collections\Test\TestResultCollection;
use App\Repositories\BaseRepository;
use App\Models\Test\TestResult;
use App\Domain\Repositories\Test\TestResultRepositoryContract;

/**
 * Class TestResultRepository
 * @package App\Repositories\Test
 */
class TestResultRepository extends BaseRepository implements TestResultRepositoryContract
{
    protected $source = TestResult::class;

    /**
     * @param int $testId
     * @param int $percentFrom
     * @param int $percentTo
     * @param int|null $testResultId
     * @return TestResultCollection|null
     */
    public function getIntersectionResults(int $testId, int $percentFrom, int $percentTo, ?int $testResultId = null): ?TestResultCollection
    {
        $query = $this->getQueryBuilder()
            ->where('percent_from', '<=', $percentTo)
            ->where('percent_to', '>=', $percentFrom)
            ->where('test_id', $testId);

        if ($testResultId !== null) {
            $query->where('id', '!=', $testResultId);
        }

        return $query->get();
    }

    /**
     * @param int $testId
     * @param int $percent
     * @return TestResult|null
     */
    public function getTestResultByPercent(int $testId, int $percent): ?TestResult
    {
        return $this->getQueryBuilder()
            ->where('test_id', $testId)
            ->where('percent_from', '<=', $percent)
            ->where('percent_to', '>=', $percent)
            ->first();
    }
}
