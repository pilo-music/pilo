<?php


namespace App\Http\Repositories\V1\Playlist;


use App\Models\Album;
use App\Models\Playlist;

class Random
{
    protected $count;

    public function __construct()
    {
        $this->count = Album::DEFAULT_ITEM_COUNT;
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
        $items = Playlist::query()->where('status', Playlist::STATUS_ACTIVE)->get();

        if ($this->count > $items->count())
            $this->count = $items->count();

        $items = $items->random($this->count);

        return $items;
    }
}
