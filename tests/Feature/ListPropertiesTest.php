<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use Mockery\MockInterface;
use App\Actions\Properties\ListProperties;
use App\Exceptions\EasyBrokerServiceException;
use App\Services\EasyBrokerService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListPropertiesTest extends TestCase
{
    public function test_success_response()
    {
        $stub = json_decode($this->loadStub('get-properties.json'));

        $expectedGetProperties = [
            'status' => 200,
            'data' => $stub,
        ];

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedGetProperties) {
            $mock->shouldReceive('getProperties')
                ->once()
                ->andReturn($expectedGetProperties);
        });

        $response = $this->get('/propiedades');

        $response->assertStatus(200);
        $response->assertViewIs('pages.list-properties');
        $response->assertViewHasAll(['properties', 'pagination']);
    }

    public function test_error_response()
    {
        $this->mock(EasyBrokerService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getProperties')
                ->once()
                ->andReturn([
                    'status' => 500,
                    'error' => 'Service unavailable',
                ]);
        });

        $response = $this->get('/propiedades');

        $response->assertStatus(500);
    }
}
