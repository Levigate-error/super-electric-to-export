<?php

use App\Models\Test\Test;

/**
 * Class TestsFakeSeeder
 */
class TestsFakeSeeder extends BaseFakeSeeder
{
    /**
     * @var int
     */
    protected $entityCount = 3;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate tests';

    /**
     * @var string
     */
    protected $truncateTable = 'tests';

    /**
     * @return mixed
     */
    protected function createEntity()
    {
        return factory(Test::class)->create();
    }
}
