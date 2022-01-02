<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\EasyBrokerService;
use App\Actions\Properties\ShowProperty;
use App\Exceptions\EasyBrokerServiceException;

class ShowPropertyTest extends TestCase
{
    public function test_handle_method()
    {
        $expectedGetProperty = [
            'status' => 404,
            'error' => 'No se encontró la propiedad especificada.'
        ];
        $propertyId = 'EB-XXXX';


        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedGetProperty) {
            $mock->shouldReceive('getProperty')
                ->once()
                ->andReturn($expectedGetProperty);
        });

        $this->expectException(EasyBrokerServiceException::class);

        ShowProperty::run($propertyId);

        $propertyId = 'EB-C0118';
        $expectedGetProperty['data'] = (object) [
            'property_id' => $propertyId
        ];

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedGetProperty) {
            $mock->shouldReceive('showProperty')
                ->once()
                ->andReturn($expectedGetProperty);
        });

        $this->assertEquals($expectedGetProperty['data'], ShowProperty::run($propertyId));
    }
}
