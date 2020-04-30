<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CastInfo extends Component
{
    public $casts;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($casts)
    {
        $this->casts = $casts;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cast-info');
    }
}
