<?php
namespace App\Utils\Synchronizations\Beatle;

use App\Models\Loyalty\LoyaltyReceipt;
use App\Utils\Synchronizations\AbstractProvider;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Support\Facades\Storage;

class BeatleProvider extends AbstractProvider
{

    protected $client;

    protected $baseUrl;

    public function __construct(array $config)
    {
        $this->baseUrl = config('app.debug') 
            ? $config['testBaseUrl']
            : $config['baseUrl'];

        $this->client = new Guzzle(['headers' => [
            'Token' => config('app.debug') 
                ? $config['testAuthToken']
                : $config['prodAuthToken']
        ]]);
    }

    public function checkInit(): bool
    {
        return $this->client instanceof Guzzle;
    }

    public function getProviderCode(): string
    {
        return 'Beatle';
    }

    public function getFullUrl(string $relativeUrl)
    {
        return "{$this->baseUrl}/{$relativeUrl}";
    }

    public function addReceipt(LoyaltyReceipt $receipt)
    {
        if ($receipt->images()->exists()){
            $responseContent = $this->addPhotoReceipt($receipt);
        } else {
            $responseContent = $this->addManualReceipt($receipt);
        }

        return $responseContent;
    }

    protected function responseHandler(string $title, array $responseContent, LoyaltyReceipt $receipt): array
    {
        if (isset($responseContent['error'])) {
            $this->logError('beatle', $title, ['response' => $responseContent]);;
        }
        if (
            isset($responseContent['id']) && 
            !$receipt->externalEntityBySystem($this->getProviderCode())
        ){
            $receipt->externalEntities()->create([  
                'system' => $this->getProviderCode(),
                'source_type' => get_class($receipt),
                'external_id' => $responseContent['id'],
            ]);
        }
        return $responseContent;
    }

    protected function addPhotoReceipt(LoyaltyReceipt $receipt): array
    {
        $files = $receipt->images()->get();
        $data = [];
        foreach ($files as $file) {
            $data[] = [
                'name' => 'receipt',
                'contents' => Storage::disk('public')->get($file->path),
                'filename' => $file->path,
            ];
        }
        $userData = $this->getUserData($receipt);
        foreach ($userData as $key => $value) {
            $data[] = [
                'name' => $key,
                'contents' => $value,
            ];
        }
        $response = $this->client->post($this->getFullUrl('add-receipt-image'), [
            'multipart' => $data,
        ]);
        return $this->responseHandler('photoReceipt', json_decode($response->getBody()->getContents(), true), $receipt);
    }

    protected function addManualReceipt(LoyaltyReceipt $receipt): array
    {
        $data = [
            'fn' => $receipt->fn,
            'fp' => $receipt->fp,
            'i' => $receipt->fd,
            's' => $receipt->amount,
            't' => $receipt->created_at->timestamp,
        ];

        $data = array_merge($data, $this->getUserData($receipt));

        $response = $this->client->post($this->getFullUrl('add-receipt-data'), [
            'json' => $data,
        ]);

        return $this->responseHandler('manualReceipt', json_decode($response->getBody()->getContents(), true), $receipt);
    }

    private function getUserData(LoyaltyReceipt $receipt): array
    {
        $user = $receipt->user;
        return [
            'userOuterId' => $user->id,
            'userPhone' => $user->phone,
            'userEmail' => $user->email,
            'userName' => "{$user->first_name} {$user->last_name}",
        ];
    }
}