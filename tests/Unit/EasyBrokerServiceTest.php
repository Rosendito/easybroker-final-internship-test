<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\EasyBrokerService as EBService;
use Tests\CreateGuzzleMock;

class EasyBrokerServiceTest extends TestCase
{
    use CreateGuzzleMock;

    public function test_fetch_method()
    {
        $mockHandler = $this->createGuzzleMock([
            $this->responseMock(200, '{ "content": "Response success" }'),
            $this->errorMock(
                $this->responseMock(404, '{ "error": "Resource not found" }'),
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

    public function test_get_properties_method()
    {
        $page = 1;
        $limit = 15;
        $search = [
            'statuses' => 'published',
        ];

        $successResponseStub = $this->loadStub('get-properties.json');

        $mockHandler = $this->createGuzzleMock([
            $this->responseMock(200, $successResponseStub),
            $this->errorMock(
                $this->responseMock(400, '{ "error": "El parametro search es inválido" }'),
                'Resource not found', 'GET', '/test'
            ),
        ]);

        $service = new EBService($mockHandler);

        $response = $service->getProperties($page, $limit, $search);

        $this->assertCount(15, $response['data']->content);
        $this->assertEquals(200, $response['status']);

        $search['statuses'] = 'invalid_status';

        $response = $service->getProperties($page, $limit, $search);

        $this->assertEquals(400, $response['status']);
        $this->assertEquals('El parametro search es inválido', $response['error']);
    }
}
