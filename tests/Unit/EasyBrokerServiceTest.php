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
                'Invalid request',
                'GET',
                '/v1/properties'
            ),
        ]);

        $service = new EBService($mockHandler);

        // Success response
        $response = $service->getProperties($page, $limit, $search);

        $this->assertCount(15, $response['data']->content);
        $this->assertEquals(200, $response['status']);

        $search['statuses'] = 'invalid_status';

        // Error response
        $response = $service->getProperties($page, $limit, $search);

        $this->assertEquals(400, $response['status']);
        $this->assertEquals('El parametro search es inválido', $response['error']);
    }

    public function test_get_property_method()
    {
        $propertyId = 'EB-C0118';

        $successResponseStub = $this->loadStub('get-property.json');

        $mockHandler = $this->createGuzzleMock([
            $this->responseMock(200, $successResponseStub),
            $this->errorMock(
                $this->responseMock(404, '{ "error": "No se encontró la propiedad" }'),
                'Resource not found',
                'GET',
                '/v1/properties/' . $propertyId
            ),
        ]);

        $service = new EBService($mockHandler);

        // Success response
        $response = $service->getProperty($propertyId);

        $expectedResponse = json_decode($successResponseStub);

        $this->assertEquals(200, $response['status']);
        $this->assertEquals($expectedResponse, $response['data']);

        // Error response
        $response = $service->getProperty('invalid_property_id');

        $this->assertEquals(404, $response['status']);
        $this->assertEquals('No se encontró la propiedad', $response['error']);
    }

    public function test_submit_method()
    {
        $mockHandler = $this->createGuzzleMock([
            $this->responseMock(201, '{ "status": "successful" }'),
            $this->errorMock(
                $this->responseMock(400, '{ "error": "Some fields are missing" }'),
                'Invalid request',
                'POST',
                '/test'
            ),
        ]);

        $service = new EBService($mockHandler);

        // Success response
        $response = $service->submit('/test', []);

        $this->assertEquals(201, $response['status']);
        $this->assertEquals('successful', $response['data']->status);

        // Error response
        $response = $service->submit('/test', []);

        $this->assertEquals(400, $response['status']);
        $this->assertEquals('Some fields are missing', $response['error']);
    }
}
