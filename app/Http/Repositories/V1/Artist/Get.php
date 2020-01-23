<?php

namespace App\Http\Repositories\V1\Artist;

use App\Models\Artist;

class Get
{
    protected $sort;
    protected $count;
    protected $page;
    protected $toJson;

    public function __construct()
    {
        $this->sort = Artist::DEFAULT_ITEM_SORT;
        $this->count = Artist::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->toJson = false;
    }

    /**
     * Set the value of sort
     *
     * @return  self
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Set the value of count
     *
     * @return  self
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Set the value of page
     *
     * @return  self
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Set the value of toJson
     *
     * @return  self
     */
    public function setToJson(bool $toJson = true)
    {
        $this->toJson = $toJson;

        return $this;
    }

    public function build()
    {

        $artists = Artist::query()->where('status', Artist::STATUS_ACTIVE);

        switch ($this->sort) {
            case Artist::SORT_LATEST:
                $artists = $artists->latest();
                break;
            case  Artist::SORT_BEST:
                $artists = $artists->where('is_best', true)->latest();
                break;
            default:
                break;
        }

        $artists = $artists->skip(($this->page - 1) * $this->count)->take($this->count)->get();

        if ($this->toJson) {
            $artists = ArtistRepo::getInstance()->toJsonArray()->setArtists($artists)->build();
        }

        return $artists;
    }
}
