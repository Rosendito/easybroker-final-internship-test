<?php

namespace Tests;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\ClientException;

trait CreateGuzzleMock
{
    /**
     * Create mock handler stack
     *
     * @param array $mocks
     * @return HandlerStack
     */
    protected function createGuzzleMock(array $mocks): HandlerStack
    {
        return HandlerStack::create(
            new MockHandler($mocks)
        );
    }

    /**
     * Get response mock
     *
     * @param integer $status
     * @param string $body
     * @param array $headers
     * @return Response
     */
    protected function responseMock(
        int $status,
        string $body,
        array $headers = []
    ): Response
    {
        return new Response(
            $status,
            $headers,
            $body
        );
    }

    /**
     * Get error mock
     *
     * @param Response $response
     * @param string $message
     * @param string $method
     * @param string $path
     * @return ClientException
     */
    protected function errorMock(
        Response $response,
        string $message = 'Internal Server Error',
        string $method = 'GET',
        string $path = '/test'
    ): ClientException
    {
        return new ClientException($message,
            new Request($method, $path),
            $response
        );
    }

    /**
     * Load stub file
     *
     * @param string $filename
     * @return string|null
     */
    protected function loadStub(string $filename): ?string
    {
        return file_get_contents(__DIR__ . '/stubs/' . $filename);
    }
}
