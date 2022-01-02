<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\EasyBrokerService;

class ShowPropertyTest extends TestCase
{
    public function test_success_response()
    {
        $stub = json_decode($this->loadStub('get-property.json'));

        $expectedGetProperty = [
            'status' => 200,
            'data' => $stub,
        ];

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedGetProperty) {
            $mock->shouldReceive('getProperty')
                ->once()
                ->andReturn($expectedGetProperty);
        });

        $response = $this->get('/propiedades/EB-C0118');

        $response->assertStatus(200);
        $response->assertViewIs('pages.show-property');
        $response->assertViewHas('property');
    }

    public function test_error_response()
    {
        $this->mock(EasyBrokerService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getProperty')
                ->once()
                ->andReturn([
                    'status' => 404,
                    'error' => 'No se encontró la propiedad especificada.',
                ]);
        });

        $response = $this->get('/propiedades/EB-XXXXX');

        $response->assertStatus(500);
    }
}
