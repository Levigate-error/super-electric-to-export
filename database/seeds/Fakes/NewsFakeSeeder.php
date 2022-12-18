<?php

use App\Models\News;

/**
 * Class NewsFakeSeeder
 */
class NewsFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 30;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate News';

    /**
     * @var string
     */
    protected $truncateTable = 'news';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(News::class)->create();
    }
}
