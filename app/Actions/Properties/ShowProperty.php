<?php

namespace App\Actions\Properties;

use Illuminate\Contracts\View\View;
use App\Actions\EasyBrokerActionBase;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowProperty extends EasyBrokerActionBase
{
    use AsAction;

    /**
     * Handle the action.
     *
     * @param string $propertyId
     * @return object
     */
    public function handle(string $propertyId): object
    {
        $response = $this->service->getProperty($propertyId);

        if ($response['status'] !== 200) {
            $this->handleError($response);
        }

        return $response['data'];
    }

    /**
     * Controller action view.
     *
     * @param string $propertyId
     * @return View
     */
    public function asController(string $propertyId): View
    {
        return view('pages.show-property', [
            'property' => $this->handle($propertyId),
        ]);
    }
}
