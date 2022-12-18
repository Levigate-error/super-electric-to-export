<?php

namespace App\Console\Commands\SendData;

use App\Models\Loyalty\LoyaltyReceipt;
use App\Models\User;

use Illuminate\Console\Command;
use GuzzleHttp;
use Illuminate\Support\Facades\Storage;

class UsersAndReceiptsExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send-remote:users-and-receipts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all users to remote server';

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
        $this->info('Start users export to remote server');

        $users = User::select('phone', 'email', 'first_name as firstName', 'last_name as lastName')->where('sended_to_remote', 0)->get();

        $client = new GuzzleHttp\Client(['headers' => ['Content-Type' => 'application/json']]);

        foreach ($users as $user) {

            $response = $client->post('https://promo.legrand.ru/api/remote/user-add?sid=vLzGMyJOpfjRXrzHSwhRig73', ['body' => json_encode($user)]);

            if($response->getStatusCode() == 200)
            {
                $response = json_decode($response->getBody(), true);

                if($response['success'] == true){
                    User::find($user->id)->update(['sended_to_remote' => 1]);
                }
            }
        }


        $this->info('End users export to remote server');
        $this->info('Start Receipt Data export to remote server');

        $receipts = LoyaltyReceipt::whereNull('remote_receipt_id')->whereNotNull('receipt_datetime')->get();
        $receiptsArray = [];

        foreach ($receipts as $receipt){
            $receiptsArray['receiptData'] = ['t' => $receipt->receipt_datetime, 'fn' => $receipt->fn, 'fp' => $receipt->fp, 'i' => $receipt->fd, 's' => $receipt->amount,];
            $receiptsArray['userPhone'] = $receipt->user->phone;

            $response = $client->post('https://promo.legrand.ru/api/remote/receipt-add-manually?sid=vLzGMyJOpfjRXrzHSwhRig73', ['body' => json_encode($receiptsArray)]);

            if($response->getStatusCode() == 200)
            {
                $response = $response->getBody();
                $response = json_decode($response, true);

                if($response['success'] == true){
                    LoyaltyReceipt::find($receipt->id)->update(['remote_receipt_id' => $response['receiptId']]);
                }
            }
        }


        $this->info('End Receipt Data export to remote server');
        $this->info('Start Receipts Images (uploaded) export to remote server');
        $mimes = array('png' => 'image/png', 'jpeg' => 'image/jpeg', 'jpg' => 'image/jpeg', 'bmp' => 'image/bmp', 'heic' => 'image/heic', 'pdf' => 'application/pdf',);


        $client = new GuzzleHttp\Client();
        $receipts = LoyaltyReceipt::whereNull('remote_receipt_id')->with('images')->get();

        foreach ($receipts as $i => $receipt){
            if($i > 1) break;
            foreach ($receipt->images as $image){
                $tmp = explode('.', $image->path);

                $response = $client->post('https://promo.legrand.ru/api/remote/receipt-add?sid=vLzGMyJOpfjRXrzHSwhRig73', [
                    'multipart' => [
                        [
                            'name'     => 'userPhone',
                            'contents' => $receipt->user->phone
                        ],
                        [
                            'name'     => 'receipt',
                            'filename' => $image->path,
                            'Mime-Type'=> $mimes[end($tmp)],
                            'contents' => Storage::disk('public')->get($image->path),
                        ],
                    ]
                ]);

                if($response->getStatusCode() == 200)
                {
                    $response = json_decode($response->getBody(), true);

                    if (isset($response['success']) && $response['success'] == true) {
                        LoyaltyReceipt::find($receipt->id)->update(['remote_receipt_id' => $response['receiptId']]);
                    }
                }
            }
        }

        $this->info('End Receipts Images (uploaded) export to remote server');

        $this->info('Export is completed');
    }
}
