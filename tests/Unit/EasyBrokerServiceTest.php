<?php

namespace Tests\Unit;

use Tests\TestCase;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Exception\RequestException;
use App\Services\EasyBrokerService as EBService;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Promise\RejectedPromise;
use Tests\CreateGuzzleMock;

class EasyBrokerServiceTest extends TestCase
{
    use CreateGuzzleMock;

    public function test_fetch_method()
    {
        $mockHandler = $this->createGuzzleMock([
            $this->responseMock(200, '{ "content": "Response success" }'),
            $this->errorMock($this->responseMock(
                404,
                '{ "error": "Resource not found" }'),
                'Resource not found', 'GET', '/test'
            ),
        ]);

        $service = new EBService($mockHandler);

        // Success response
        $response = $service->fetch('/test');

        $this->assertEquals(200, $response['status']);
        $this->assertEquals('Response success', $response['data']->content);

        // Error response
        $response = $service->fetch('/test2');

        $this->assertEquals(404, $response['status']);
        $this->assertEquals('Resource not found', $response['error']);
    }
}
