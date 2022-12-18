<?php

use App\Models\Faq;

/**
 * Class FaqFakeSeeder
 */
class FaqFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 20;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate Faq';

    /**
     * @var string
     */
    protected $truncateTable = 'faqs';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(Faq::class)->create();
    }
}
