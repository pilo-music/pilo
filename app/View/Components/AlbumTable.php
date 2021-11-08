<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AlbumTable extends Component
{

    public function __construct(public $title, public $items)
    {
        //
    }

    public function render(): View|Factory|Htmlable|\Closure|string|Application
    {
        return view('components.album-table');
    }
}
