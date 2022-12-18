<?php

use App\Models\Video\Video;

/**
 * Class VideosFakeSeeder
 */
class VideosFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 20;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate Videos';

    /**
     * @var string
     */
    protected $truncateTable = 'videos';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(Video::class)->create();
    }
}
