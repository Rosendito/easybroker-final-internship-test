<?php

namespace Tests\Feature;

use Tests\TestCase;
use Mockery\MockInterface;
use App\Services\EasyBrokerService;

class SendContactForProperty extends TestCase
{
    public function test_success_response()
    {
        $expectedGetProperty = [
            'status' => 200,
            'data' => 'Success',
        ];

        $this->mock(EasyBrokerService::class, function (MockInterface $mock) use ($expectedGetProperty) {
            $mock->shouldReceive('getProperty')
                ->once()
                ->andReturn($expectedGetProperty);
        });

        $response = $this->post('/propiedades/EB-C0118/contacto', [
            'name' => 'John Doe',
            'email' => 'john@example.test',
            'phone' => '+56912345678',
            'message' => 'Hi, I am interested in your property.'
        ]);

        $response
            ->assertStatus(200)
            ->assertRedirect('/propiedades/EB-C0118')
            ->assertSessionHas('success', 'Mensaje enviado correctamente.');
    }

    public function test_error_response()
    {
        $response = $this->post('/propiedades/EB-C0118/contacto');

        $response
            ->assertStatus(422)
            ->assertRedirect('/propiedades/EB-C0118')
            ->assertSessionHasErrors('name', 'email', 'phone', 'message');
    }
}
