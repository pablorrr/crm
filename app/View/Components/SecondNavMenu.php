<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SecondNavMenu extends Component
{
    public $className;
    public $menuVar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($className, $menuVar)
    {
        $this->className = $className;
        $this->menuVar = $menuVar;
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.second-nav-menu');
    }
}
