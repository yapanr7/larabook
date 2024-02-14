<?php

// app/View/Components/Breadcrumb.php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $image;
    public $title;
    public $description;

    /**
     * Create a new component instance.
     *
     * @param  string  $image
     * @param  string  $title
     * @param  string  $description
     */
    public function __construct($image = null, $title = null, $description = null)
    {
        $this->image = $image;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
