<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Datatable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $tableId,
        public array $tableHeaders,
        public string $getDataUrl,
        public array $tableColumns,
        public string  $deleteDataUrl = ''
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.datatable');
    }
}
