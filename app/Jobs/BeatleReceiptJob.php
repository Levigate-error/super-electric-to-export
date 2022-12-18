<?php

namespace App\Jobs;

use App\Models\Loyalty\LoyaltyReceipt;
use App\Utils\Synchronizations\SynchronizationManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BeatleReceiptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $receipt;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(LoyaltyReceipt $receipt)
    {
        $this->receipt = $receipt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $provider = (new SynchronizationManager(app()))->driver('Beatle');
        $provider->addReceipt($this->receipt);
    }
}
