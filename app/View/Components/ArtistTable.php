<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ArtistTable extends Component
{
    public function __construct(public $title, public $items)
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
        return view('components.artist-table');
    }
}
