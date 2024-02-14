<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardDashboard extends Component
{
    public $icon;
    public $total;
    public $name;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($icon, $total, $name)
    {
        $this->icon = $icon;
        $this->total = $total;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render(): View|Closure|string
    {
        return view('components.card-dashboard');
    }
}
