<?php

namespace App\Utils\Synchronizations\SalesForce;

use App\Utils\Synchronizations\AbstractProvider;
use GuzzleHttp\Client as GuzzleClient;
use Exception;

/**
 * Class SalesForceProvider
 * @package App\Utils\Synchronizations\SalesForce
 */
class SalesForceProvider extends AbstractProvider
{
    /**
     * @var array
     */
    private $authContext;

    /**
     * @var GuzzleClient
     */
    private $client;

    /**
     * SalesForceProvider constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->auth();
        $this->initClient();
    }

    /**
     * @return bool
     */
    public function checkInit(): bool
    {
        return is_array($this->authContext) && $this->client instanceof GuzzleClient;
    }

    /**
     * @return string
     */
    public function getProviderCode(): string
    {
        return 'SalesForce';
    }

    /**
     * @return string
     */
    protected function getSobjectsMainUrl(): string
    {
        return $this->config['urls']['sobjects_main_url'];
    }

    protected function auth(): void
    {
        $url = $this->config['urls']['auth'];
        if ($this->debugMode) {
            $url = $this->config['urls']['sandboxTokenAuth'];
        }

        $client = new GuzzleClient();

        $response = $client->post($url, [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => $this->config['apiKey'],
                'client_secret' => $this->config['apiSecret'],
                'username' => $this->config['login'],
                'password' => $this->config['password'],
            ],
        ]);
        $responseContent = $response->getBody()->getContents();

        $this->authContext = json_decode($responseContent, true);
    }

    protected function initClient(): void
    {
        $clientConfig = [
            'base_uri' => $this->authContext['instance_url'],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->authContext['access_token'],
                'Accept'     => 'application/json',
            ]
        ];

        $this->client = new GuzzleClient($clientConfig);
    }

    /**
     * @param array $parameters
     * @return array|bool
     */
    protected function addElectricianProcessing(array $parameters)
    {
        try {
            $response = $this->client->post($this->getSobjectsMainUrl() . 'Account', [
                'json' => $parameters,
            ]);
            $responseContent = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            $this->logError('sales-force', 'addElectricianProcessing', ['error' => $e->getMessage()]);

            return false;
        }

        return $this->returnHandler('addElectricianProcessing', $responseContent);
    }

    /**
     * @param string $externalId
     * @param array $parameters
     * @return array|bool
     */
    protected function updateElectricianProcessing(string $externalId, array $parameters)
    {
        try {
            $response = $this->client->patch($this->getSobjectsMainUrl() . 'Account/' . $externalId, [
                'json' => $parameters,
            ]);
            $responseContent = json_decode($response->getBody()->getContents(), true);

            /**
             * Чудо API при успешном обновлении ничего не возвращает
             */
            if ($responseContent === null) {
                $responseContent = [
                    'success' => true,
                ];
            }
        } catch (Exception $e) {
            $this->logError(
                'sales-force', 'updateElectricianProcessing ID: ' . $externalId,
                ['error' => $e->getMessage()]
            );

            return false;
        }

        return $this->returnHandler('updateElectricianProcessing ID: ' . $externalId, $responseContent);
    }

    /**
     * @param array $parameters
     * @return array|bool
     */
    protected function addProjectProcessing(array $parameters)
    {
        try {
            $response = $this->client->post($this->getSobjectsMainUrl() . 'Opportunity', [
                'json' => $parameters,
            ]);
            $responseContent = json_decode($response->getBody()->getContents(), true);
        } catch (Exception $e) {
            $this->logError('sales-force', 'addProjectProcessing', ['error' => $e->getMessage()]);

            return false;
        }

        return $this->returnHandler('addProjectProcessing', $responseContent);
    }

    /**
     * @param string $externalId
     * @param array $parameters
     * @return array|bool
     */
    protected function updateProjectProcessing(string $externalId, array $parameters)
    {
        try {
            $response = $this->client->patch($this->getSobjectsMainUrl() . 'Opportunity/' . $externalId, [
                'json' => $parameters,
            ]);
            $responseContent = json_decode($response->getBody()->getContents(), true);

            /**
             * Чудо API при успешном обновлении ничего не возвращает
             */
            if ($responseContent === null) {
                $responseContent = [
                    'success' => true,
                ];
            }
        } catch (Exception $e) {
            $this->logError(
                'sales-force', 'updateProjectProcessing ID: ' . $externalId,
                ['error' => $e->getMessage()]
            );

            return false;
        }

        return $this->returnHandler('updateProjectProcessing ID: ' . $externalId, $responseContent);
    }

    /**
     * @param string $title
     * @param array $responseContent
     * @return array|bool
     */
    protected function returnHandler(string $title, array $responseContent)
    {
        if (!$responseContent['success']) {
            $this->logError('sales-force', $title, ['response' => $responseContent]);

            return false;
        }

        return $responseContent;
    }
}
