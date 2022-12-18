<?php

namespace Tests\Feature\Service\Loyalty;

use App\Domain\ServiceContracts\Loyalty\LoyaltyUserProposalServiceContract;
use App\Models\Loyalty\LoyaltyUserProposal;
use Tests\TestCase;

/**
 * Class LoyaltyUserProposalServiceTest
 * @package Tests\Feature\Service\Loyalty
 */
class LoyaltyUserProposalServiceTest extends TestCase
{
    protected $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = app()->make(LoyaltyUserProposalServiceContract::class);
    }

    public function testCheckProductCodeUsage(): void
    {
        $userProposal = factory(LoyaltyUserProposal::class)->create();

        $this->assertTrue($this->service->checkProductCodeUsage($userProposal->code));

        $this->assertFalse($this->service->checkProductCodeUsage('wrongCode'));
    }
}
