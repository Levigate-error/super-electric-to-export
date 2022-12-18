<?php

use App\Models\Video\VideoCategory;

/**
 * Class VideoCategoriesFakeSeeder
 */
class VideoCategoriesFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 5;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate Video Categories';

    /**
     * @var string
     */
    protected $truncateTable = 'video_categories';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(VideoCategory::class)->create();
    }
}
