<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery\MockInterface;
use Tests\CreateGuzzleMock;
use App\Services\EasyBrokerService;
use Lorisleiva\Actions\ActionRequest;
use App\Actions\Properties\ListProperties;
use App\Exceptions\EasyBrokerServiceException;

class ListPropertiesTest extends TestCase
{
    public function test_prepare_params_method()
    {
        $request = new ActionRequest();

        $action = ListProperties::make();

        // Test default params returned by prepareParams()
        $this->assertEquals(
            [
                'page' => 1,
                'limit' => 15,
                'search' => ['statuses' => 'published']
            ],
            $action->prepareParams($request),
        );

        $request = new ActionRequest([
            'page' => 2,
            'per_page' => 10,
            'min_price' => 500000,
            'max_price' => 1000000,
        ]);

        // Test params returned by prepareParams() passing custom params
        $this->assertEquals(
            [
                'page' => 2,
                'limit' => 10,
                'search' => [
                    'min_price' => 500000,
                    'max_price' => 1000000,
                    'statuses' => 'published',
                ],
            ],
            $action->prepareParams($request),
        );
    }

    public function test_handle_method()
    {
        $expectedGetProperties = [
            'status' => 200,
            'data' => (object) [
                'content' => [
                    ['id' => 1, 'name' => 'Property 1'],
                    ['id' => 2, 'name' => 'Property 2'],
                ],
                'pagination' => []
            ],
        ];

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedGetProperties) {
            $mock->shouldReceive('getProperties')
                ->once()
                ->andReturn($expectedGetProperties);
        });

        $request = new ActionRequest();

        $response = ListProperties::run($request);

        $this->assertArrayHasKey('properties', $response);
        $this->assertArrayHasKey('pagination', $response);
        $this->assertCount(2, $response['properties']);

        $expectedGetProperties = [
            'status' => 500,
            'error' => 'Internal Server Error',
        ];

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedGetProperties) {
            $mock->shouldReceive('getProperties')
                ->once()
                ->andReturn($expectedGetProperties);
        });

        $this->expectException(EasyBrokerServiceException::class);

        ListProperties::run($request);
    }
}
