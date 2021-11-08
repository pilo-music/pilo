<?php

namespace App\View\Components;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public function __construct(public $title = null, public $link = null)
    {
    }

    public function render(): View|Factory|Htmlable|\Closure|string|Application
    {
        return view('components.table');
    }
}
