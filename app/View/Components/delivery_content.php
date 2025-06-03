<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Delivery;

class delivery_content extends Component
{
    public $deliveries;

    /**
     * Create a new component instance.
     */
    public function __construct($deliveries = null)
    {
        $this->deliveries = $deliveries ?? Delivery::with('user')->latest()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delivery_content');
    }
}
