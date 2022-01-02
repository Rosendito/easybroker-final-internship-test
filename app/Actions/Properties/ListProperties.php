<?php

namespace App\Actions\Properties;

use App\Actions\EasyBrokerActionBase;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class ListProperties extends EasyBrokerActionBase
{
    use AsAction;

    /**
     * Handle the action request.
     *
     * @param ActionRequest $request
     * @return array
     */
    public function handle(ActionRequest $request): array
    {
        $params = $this->prepareParams($request);
        $response = $this->service->getProperties(...$params);

        if ($response['status'] !== 200) {
            $this->handleError($response);
        }

        return (array) $response['data']['content'];
    }

    /**
     * Prepare params for get properties from EasyBrokerService
     *
     * @param ActionRequest $request
     * @return array
     */
    public function prepareParams(ActionRequest $request): array
    {
        $params = [
            'page' => $request->input('page', 1),
            'limit' => $request->input('per_page', 15),
        ];

        $search = [];

        if ($request->has('min_price')) {
            $search['min_price'] = $request->input('min_price');
        }

        if ($request->has('max_price')) {
            $search['max_price'] = $request->input('max_price');
        }

        if (!empty($search)) {
            $params['search'] = $search;
        }

        return $params;
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'page' => 'sometimes|nullable|integer|min:1',
            'per_page' => 'sometimes|nullable|integer|min:1|max:30',
            'min_price' => 'sometimes|nullable|integer|min:1',
            'max_price' => 'sometimes|nullable|integer|min:1',
        ];
    }
}
