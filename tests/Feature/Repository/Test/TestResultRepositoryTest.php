<?php

namespace Tests\Feature\Repository\Test;

use App\Models\Test\Test;
use App\Models\Test\TestResult;
use Tests\TestCase;
use App\Domain\Repositories\Test\TestResultRepositoryContract;

/**
 * Class TestResultRepositoryTest
 * @package Tests\Feature\Repository\Test
 */
class TestResultRepositoryTest extends TestCase
{
    /**
     * @var TestResultRepositoryContract
     */
    protected $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = app()->make(TestResultRepositoryContract::class);
    }

    /**
     * Поиск пересечения диапазонов процентов от и до
     */
    public function testGetIntersectionResults(): void
    {
        $test = factory(Test::class)->create();

        factory(TestResult::class)->create([
            'test_id' => $test->id,
            'percent_from' => 1,
            'percent_to' => 10,
        ]);

        $testResultWithoutIntersection = factory(TestResult::class)->make([
            'test_id' => $test->id,
            'percent_from' => 11,
            'percent_to' => 20,
        ]);

        $resultWithoutIntersection = $this->repository->getIntersectionResults($test->id, $testResultWithoutIntersection->percent_from, $testResultWithoutIntersection->percent_to);

        $this->assertEmpty($resultWithoutIntersection);

        $testResultWitIntersection = factory(TestResult::class)->make([
            'test_id' => $test->id,
            'percent_from' => 9,
            'percent_to' => 20,
        ]);

        $resultWitIntersection = $this->repository->getIntersectionResults($test->id, $testResultWitIntersection->percent_from, $testResultWitIntersection->percent_to);

        $this->assertNotEmpty($resultWitIntersection);
    }
}
