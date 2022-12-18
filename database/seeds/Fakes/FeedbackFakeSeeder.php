<?php

use App\Models\Feedback;

/**
 * Class FeedbackFakeSeeder
 */
class FeedbackFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 20;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate feedback';

    /**
     * @var string
     */
    protected $truncateTable = 'feedback';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(Feedback::class)->create();
    }
}
