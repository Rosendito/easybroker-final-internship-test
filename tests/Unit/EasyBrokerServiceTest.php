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

class EasyBrokerServiceTest extends TestCase
{
    public function test_fetch_method()
    {
        // Enqueue responses
        $mockHandler = new MockHandler([
            new Response(200, [], '{ "content": "Response success" }'),
            new ClientException('x', new Request('GET', 'test'), new Response(404, [], '{ "error": "Resource not found" }')),
        ]);

        $handlerStack = HandlerStack::create($mockHandler);

        $service = new EBService($handlerStack);

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
