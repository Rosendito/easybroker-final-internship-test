<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PropertyAgent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        protected object $agent
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.property-agent', [
            'agent' => $this->agent
        ]);
    }
}
