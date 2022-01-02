<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PropertyOperations extends Component
{
    /**
     * Operations to display.
     *
     * @var array
     */
    protected array $operations;

    /**
     * Operations types.
     *
     * @var array
     */
    protected array $propertyTypes = [
        'sale' => [
          'class' => 'is-success',
          'text' => 'Venta'
        ],
        'rental' => [
          'class' => 'is-info',
          'text' => 'Arriendo',
        ],
        'temporary_rental' => [
          'class' => 'is-danger',
          'text' => 'Arriendo temporal',
        ],
      ];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(array $operations)
    {
        $this->operations = $operations;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.property-operations', [
            'operations' => $this->operations,
            'propertyTypes' => $this->propertyTypes,
        ]);
    }
}
