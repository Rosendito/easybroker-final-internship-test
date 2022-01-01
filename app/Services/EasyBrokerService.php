<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

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
     * @param integer $page
     * @param integer $limit
     * @param array $search
     * @return array
     */
    public function getProperties(
        int $page = 1,
        int $limit = 15,
        array $search = []
    ): array
    {
        $query = [
            'page' => $page,
            'limit' => $limit,
        ];

        if (!empty($search)) {
            $query['search'] = $search;
        }

        return $this->fetch('/properties', $query);
    }

    public function getProperty(string $propertyId): array
    {
        return $this->fetch('/properties/' . $propertyId);
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
        // Guzzle only allows adding the base api, that's why the prefix v1 is added for convenience
        $path = '/v1' . $path;

        try {
            return $this->getSuccessResponse($this->http->get($path, [
                'query' => $queryParams,
            ]));
        } catch (ClientException $error) {
            return $this->getErrorResponse($error);
        }
    }

    public function submit(string $path, array $form): array
    {
        $path = '/v1' . $path;

        try {
            return $this->getSuccessResponse($this->http->post($path, [
                'json' => $form,
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
