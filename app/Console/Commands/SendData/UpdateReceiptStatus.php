<?php

namespace App\Console\Commands\SendData;

use App\Models\Loyalty\LoyaltyReceipt;

use Illuminate\Console\Command;
use GuzzleHttp;

class UpdateReceiptStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-remote:update-receipt-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update all receipts status from remote server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json']]);


        $receipts = LoyaltyReceipt::whereNotNull('remote_receipt_id')->get();

        $this->info('Receipts status update is started.');

        foreach ($receipts as $i => $receipt){

            $response = $client->post('https://promo.legrand.ru/api/remote/receipt-get-status?sid=vLzGMyJOpfjRXrzHSwhRig73', ['body' => json_encode(['receiptId' => $receipt->remote_receipt_id])]);

            if($response->getStatusCode() == 200)
            {
                $response = json_decode($response->getBody(), true);

                $result = 1;
                if($response['receipt']['status'] == 'new'){
                    $result = 1;
                } elseif($response['receipt']['status'] == 'moderation'){
                    $result = 1;
                } elseif($response['receipt']['status'] == 'waiting'){
                    $result = 1;
                } elseif($response['receipt']['status'] == 'success'){
                    $result = 2;
                }elseif($response['receipt']['status'] == 'error'){
                    $result = 3;
                }

                if(count($response) > 0 && $response['success'] == true){
                    LoyaltyReceipt::find($receipt->id)->update(['status_id' => $result]);
                }
            }
        }

        $this->info('Receipts status update is completed.');
    }
}
