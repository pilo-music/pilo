<?php

namespace App\Http\Repositories\V1\Music;

use App\Models\Music;

class Random
{
    protected $count;

    public function __construct()
    {
        $this->count = Music::DEFAULT_ITEM_COUNT;
    }

    /**
     * @param int $count
     * @return Random
     */
    public function setCount(int $count): Random
    {
        $this->count = $count;
        return $this;
    }


    public function build()
    {
        $items = Music::query()->where('status', Music::STATUS_ACTIVE)->get();

        if ($this->count > $items->count())
            $this->count = $items->count();

        $items = $items->random($this->count);

        return $items;
    }
}
