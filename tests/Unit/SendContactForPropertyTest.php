<?php

namespace Tests\Unit;

use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\EasyBrokerService;
use Lorisleiva\Actions\ActionRequest;
use App\Exceptions\EasyBrokerServiceException;
use App\Actions\Properties\SendContactForProperty;

class SendContactForPropertyTest extends TestCase
{
    public function test_handle_method()
    {
        $expectedResponse = [
            'status' => 422,
            'error' => 'Some fields are missing.'
        ];
        $propertyId = 'EB-C0118';

        $request = new ActionRequest([], []);

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedResponse) {
            $mock->shouldReceive('saveContactRequest')
                ->once()
                ->andReturn($expectedResponse);
        });

        $this->expectException(EasyBrokerServiceException::class);

        SendContactForProperty::run($request, $propertyId);

        $expectedResponse['data'] = (object) [
            'status' => 'success'
        ];

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedResponse) {
            $mock->shouldReceive('saveContactRequest')
                ->once()
                ->andReturn($expectedResponse);
        });

        $request = new ActionRequest([], [
            'name' => 'John Doe',
            'email' => 'john@example.test',
            'phone' => '+56912345678',
            'message' => 'Hi, I am interested in your property.'
        ]);

        $this->assertEquals(
            $expectedResponse['data'],
            SendContactForProperty::run($request, $propertyId)
        );
    }
}
