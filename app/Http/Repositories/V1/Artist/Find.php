<?php

namespace App\Http\Repositories\V1\Artist;

use App\Models\Artist;

class Find
{
    protected $name;
    protected $slug;
    protected $count;
    protected $page;
    protected $toJson;

    public function __construct()
    {
        $this->name = null;
        $this->slug = null;
        $this->count = Artist::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->toJson = false;
    }


    /**
     * Set the value of name
     *
     * @param $name
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set the value of slug
     *
     * @param $slug
     * @return  self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
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
     * Set the value of page
     *
     * @param $page
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
        if (isset($this->name) && !empty($this->name)) {
            /**
             *  find from name
             */
            $this->name = strval($this->name);
            $artists = Artist::query()->where('name', 'LIKE', '%' . $this->name . '%')
                ->where('status', Artist::STATUS_ACTIVE)
                ->skip(($this->page - 1) * $this->count)->take($this->count)->get();

            if ($this->toJson) {
                $artists = ArtistRepo::getInstance()->toJsonArray()->setArtists($artists)->build();
            }

            return $artists;
        } else {
            /*
             * find from id
             */
            if (isset($this->slug)) {
                $artists = Artist::query()->where('status', Artist::STATUS_ACTIVE)
                    ->where('slug', $this->slug)->first();


                if ($this->toJson) {
                    $artists = ArtistRepo::getInstance()->toJson()->setArtist($artists)->build();
                }

                return $artists;
            }
        }
        return null;
    }
}
