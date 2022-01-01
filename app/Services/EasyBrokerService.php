<?php

namespace App\Services;

use GuzzleHttp\Client;

class EasyBrokerService
{
    /**
     * Http client
     *
     * @var Client
     */
    protected Client $http;

    /**
     * Api base url
     *
     * @var string
     */
    protected string $apiBaseUrl;

    /**
     * Api key
     *
     * @var string
     */
    protected string $apiKey;

    /**
     * Construct function
     */
    public function __construct()
    {
        $this->setConfig();
        $this->setupHttpClient();
    }

    /**
     * Set config
     *
     * @return void
     */
    protected function setConfig(): void
    {
        $config = config('app.services.easybroker');

        $this->apiBaseUrl = $config['api_url'];
        $this->apiKey = $config['api_key'];
    }

    /**
     * Setup http client
     *
     * @return void
     */
    protected function setupHttpClient(): void
    {
        $this->http = new Client([
            'base_uri' => $this->apiBaseUrl,
            'headers' => [
                'X-Authorization' => $this->apiKey,
            ],
        ]);
    }

    /**
     * Get properties
     *
     * @return array
     */
    public function getProperties(): array
    {
        $response = $this->http->get('/v1/properties');

        return  (array) json_decode($response->getBody()->getContents());
    }
}
