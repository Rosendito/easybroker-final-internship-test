<?php

namespace App\Actions;

use App\Exceptions\EasyBrokerServiceException;
use App\Services\EasyBrokerService;

class EasyBrokerActionBase
{
    /**
     * EasyBrokerService instance.
     *
     * @var EasyBrokerService
     */
    protected EasyBrokerService $service;

    /**
     * Construct function
     *
     * @param EasyBrokerService $service
     */
    public function __construct(EasyBrokerService $service)
    {
        $this->service = $service;
    }

    /**
     * Handle EasyBrokerService exception.
     *
     * @param array $response
     * @return void
     */
    public function handleError(array $response): void
    {
        throw new EasyBrokerServiceException(
            $response['error'],
            $response['status']
        );
    }
}
