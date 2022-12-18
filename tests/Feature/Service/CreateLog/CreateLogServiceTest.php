<?php

namespace Tests\Feature\Service\CreateLog;

use App\Models\Log\CreateLog;
use Tests\TestCase;
use App\Domain\ServiceContracts\Log\CreateLogServiceContract;

/**
 * Class CreateLogServiceTest
 * @package Tests\Feature\Service\CreateLog
 */
class CreateLogServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app()->make(CreateLogServiceContract::class);
    }

    /**
     * Кол-ство записей
     */
    public function testGetCreatedCount(): void
    {
        $count = 10;
        $client = 'some user-Agent';
        $type =  'some logable type';

        CreateLog::query()->truncate();

        factory(CreateLog::class, $count)->create([
            'client' => $client,
            'logable_type' => $type,
        ]);

        $this->assertEquals($this->service->getCreatedCount($client, $type), $count);
    }
}
