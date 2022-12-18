<?php

namespace Tests\Feature\Service\Test;

use App\Models\Test\Test;
use Tests\TestCase;
use App\Domain\ServiceContracts\Test\TestServiceContract;
use Tests\Feature\Traits\Testable;

/**
 * Class TestServiceTest
 * @package Tests\Feature\Service\Test
 */
class TestServiceTest extends TestCase
{
    use Testable;

    /**
     * @var TestServiceContract
     */
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app()->make(TestServiceContract::class);
    }

    /**
     * Записи для селекта.
     * Элементы массива должны быть отсотированы по названию по возрастанию.
     * Элементы массива должны быть в виде 'id' => 'title'.
     */
    public function testGetTestsForSelect(): void
    {
        Test::query()->truncate();

        $createdTests = factory(Test::class, 5)->create(['published' => true])->sortBy('title');

        $correctTestsArray = [];
        foreach ($createdTests as $createdTest) {
            $correctTestsArray[$createdTest->id] = $createdTest->title;
        }

        $tests = $this->service->getTestsForSelect();

        $this->assertEquals($correctTestsArray, $tests);
    }

    /**
     * Возвращает корреткное число элементов.
     */
    public function testGetTests(): void
    {
        Test::query()->truncate();

        $publishedTests = factory(Test::class, 5)->create(['published' => true]);
        factory(Test::class, 3)->create(['published' => false]);

        $tests = $this->service->getTests();

        $this->assertCount($publishedTests->count(), $tests);
    }

    /**
     * Возвращает корреткные детали теста.
     */
    public function testGetTest(): void
    {
        $createdTest = factory(Test::class)->create(['published' => true]);

        $test = $this->service->getTest($createdTest->id);

        $this->assertEquals([
            'id' => $createdTest->id,
            'title' => $createdTest->title,
            'image' => $createdTest->imagePath,
            'description' => $createdTest->description,
            'questions' => [],
            'created_at' => $createdTest->created_at->toIso8601String(),
        ], $test);
    }

    /**
     * Подготовка данных. Собираем только ответы, относящиеся к вопросу, и вопросы, относящиеся к тесту.
     */
    public function testPrepareTestAnswers(): void
    {
        Test::query()->truncate();

        $test = $this->prepareFullTestData();
        $anotherTest = $this->prepareFullTestData();

        $mixedTestData = $this->prepareParamsAndCorrectResponse($test, $anotherTest);

        $preparedTestAnswers = $this->service->prepareTestAnswers($test['main']['id'], $mixedTestData['params']);

        $this->assertEquals($mixedTestData['correctAnswersData'], $preparedTestAnswers->toArray());
    }
}
