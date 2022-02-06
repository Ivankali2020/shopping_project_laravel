<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SideBar extends Component
{
    public $route,$sidebarname,$active,$icon ;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($route="home",$sidebarname='default',$active='admin_home_active',$icon='pe-7s-disk ')
    {
        $this->route = $route;
        $this->sidebarname = $sidebarname;
        $this->active = $active;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.side-bar');
    }
}
