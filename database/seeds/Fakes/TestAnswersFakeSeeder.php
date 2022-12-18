<?php

use App\Models\Test\TestAnswer;

/**
 * Class TestAnswersFakeSeeder
 */
class TestAnswersFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 30;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate test answers';

    /**
     * @var string
     */
    protected $truncateTable = 'test_answers';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(TestAnswer::class)->create();
    }
}
