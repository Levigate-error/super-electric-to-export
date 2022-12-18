<?php

use App\Models\Test\TestQuestion;

/**
 * Class TestQuestionsFakeSeeder
 */
class TestQuestionsFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 30;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate test question';

    /**
     * @var string
     */
    protected $truncateTable = 'test_questions';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(TestQuestion::class)->create();
    }
}
