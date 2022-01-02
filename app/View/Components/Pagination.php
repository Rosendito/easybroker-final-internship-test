<?php

namespace App\View\Components;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Component;

class Pagination extends Component
{
    /**
     * Paginator object
     *
     * @var object
     */
    protected object $paginator;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(object $paginator)
    {
        $this->paginator = $this->createPaginator($paginator);
    }

    /**
     * Create paginator
     *
     * @param object $paginator
     * @return void
     */
    public function createPaginator(object $paginator)
    {
        return (object) [
            'pages' => ceil($paginator->total / $paginator->limit),
            'current_page' => $paginator->page,
            'has_next' => $paginator->page < $paginator->total,
            'has_previous' => $paginator->page > 1,
        ];
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.pagination', [
            'paginator' => $this->paginator,
        ]);
    }
}
