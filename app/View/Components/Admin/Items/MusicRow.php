<?php

namespace App\View\Components\Admin\Items;

use App\Models\Music;
use Illuminate\View\Component;

class MusicRow extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(protected Music $item)
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.admin.items.music-row');
    }
}
