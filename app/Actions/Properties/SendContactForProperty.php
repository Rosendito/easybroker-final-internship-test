<?php

namespace App\Actions\Properties;

use App\Actions\EasyBrokerActionBase;
use Illuminate\Http\RedirectResponse;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class SendContactForProperty extends EasyBrokerActionBase
{
    use AsAction;

    /**
     * Handle the action
     *
     * @param ActionRequest $request
     * @param string $propertyId
     * @return array
     */
    public function handle(ActionRequest $request, string $propertyId): array
    {
        $form = $request->all();
        $form['source'] = config('app.url');
        $form['property_id'] = $propertyId;

        // dd($request);

        $response = $this->service->saveContactRequest($form);

        if ($response['status'] !== 200) {
            $this->handleError($response);
        }

        return $response;
    }

    /**
     * Controller
     *
     * @param ActionRequest $request
     * @param string $propertyId
     * @return RedirectResponse
     */
    public function asController(ActionRequest $request, string $propertyId): RedirectResponse
    {
        $this->handle($request, $propertyId);

        return redirect()
            ->route('properties.show', $propertyId)
            ->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Rules.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'message' => 'required|string|max:256',
        ];
    }
}
