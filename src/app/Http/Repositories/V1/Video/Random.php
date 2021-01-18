<?php

namespace App\Http\Repositories\V1\Video;

use App\Models\Video;

class Random
{
    protected $count;

    public function __construct()
    {
        $this->count = Video::DEFAULT_ITEM_COUNT;
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
        $items = Video::query()->where('status', Video::STATUS_ACTIVE)->get();

        if ($this->count > $items->count())
            $this->count = $items->count();

        $items = $items->random($this->count);

        return $items;
    }
}
