<?php

namespace App\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\HandlerStack;

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
     *
     * @param HandlerStack|null $mockHandler
     */
    public function __construct(HandlerStack $httpMockHandler = null)
    {
        $this->setConfig();
        $this->setupHttpClient($httpMockHandler);
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
     * @param HandlerStack|null $mockHandler
     * @return void
     */
    protected function setupHttpClient(?HandlerStack $mockHandler): void
    {
        // Use a mock handler for testing if provided
        if ($mockHandler) {
            $this->http = new Client([
                'handler' => $mockHandler,
            ]);

            return;
        }

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

    /**
     * Fetch request (Method: GET)
     *
     * @param string $path
     * @param array $queryParams
     * @return array
     */
    public function fetch(string $path, array $queryParams = []): array
    {
        try {
            return $this->getSuccessResponse($this->http->get($path, [
                'query' => $queryParams,
            ]));
        } catch (ClientException $error) {
            return $this->getErrorResponse($error);
        }
    }

    /**
     * Get success response
     *
     * @param ResponseInterface $response
     * @return array
     */
    protected function getSuccessResponse(ResponseInterface $response): array
    {
        return [
            'data' => json_decode($response->getBody()->getContents()),
            'status' => $response->getStatusCode(),
        ];
    }

    /**
     * Get error response
     *
     * @param ClientException $error
     * @return array
     */
    protected function getErrorResponse(ClientException $error): array
    {
        return [
            'error' => json_decode(
                $error->getResponse()->getBody()->getContents()
            )->error,
            'status' => $error->getCode(),
        ];
    }
}
