<?php

namespace App\Http\Repositories\V1\Artist;

use App\Models\Artist;

class Random
{
    protected $count;
    protected $toJson;

    public function __construct()
    {
        $this->count = Artist::DEFAULT_ITEM_COUNT;
        $this->toJson = false;
    }

    /**
     * Set the value of count
     *
     * @param $count
     * @return  self
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Set the value of toJson
     *
     * @param bool $toJson
     * @return  self
     */
    public function setToJson(bool $toJson = true)
    {
        $this->toJson = $toJson;

        return $this;
    }


    public function build()
    {
        $items = Artist::where('status', Artist::STATUS_ACTIVE)
            ->get();


        if ($this->count > $items->count())
            $this->count = $items->count();

        $items = $items->random($this->count);

        if ($this->toJson)
            $items = ArtistRepo::getInstance()->toJsonArray()->setArtists($items)->build();

        return $items;
    }
}
