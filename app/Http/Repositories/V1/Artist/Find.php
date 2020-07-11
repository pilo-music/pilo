<?php

namespace App\Http\Repositories\V1\Artist;

use App\Models\Artist;

class Find
{
    protected $name;
    protected $slug;
    protected $id;
    protected $count;
    protected $sort;
    protected $page;
    protected $toJson;

    public function __construct()
    {
        $this->name = null;
        $this->slug = null;
        $this->count = Artist::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->toJson = false;
        $this->id = null;
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
     * @param mixed $sort
     * @return Find
     */
    public function setSort($sort): Find
    {
        $this->sort = $sort;
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

    /**
     * @param $id
     * @return Find
     */
    public function setId($id): Find
    {
        $this->id = $id;
        return $this;
    }


    public function build()
    {
        if (isset($this->name) && !empty($this->name)) {
            /**
             *  find from name
             */
            $this->name = (string)$this->name;
            $artists = Artist::query()->where('name_en', 'LIKE', '%' . $this->name . '%')
                ->orWhere('name', 'LIKE', '%' . $this->name . '%')
                ->where('status', Artist::STATUS_ACTIVE);

            switch ($this->sort) {
                case Artist::SORT_LATEST:
                    $artists = $artists->latest();
                    break;
                case  Artist::SORT_BEST:
                    $artists = $artists->orderBy('play_count');
                    break;
                case Artist::SORT_SEARCH:
                    $artists = $artists->orderBy('search_count');
                    break;
            }

            $artists = $artists->skip(($this->page - 1) * $this->count)->take($this->count)->get();

            if ($this->toJson) {
                $artists = ArtistRepo::getInstance()->toJsonArray()->setArtists($artists)->build();
            }

            return $artists;
        }

        if (isset($this->id)) {
            /**
             * find from id
             */
            $artists = Artist::query()->where('status', Artist::STATUS_ACTIVE)
                ->where('id', $this->id)->first();


            if ($this->toJson) {
                $artists = ArtistRepo::getInstance()->toJson()->setArtist($artists)->build();
            }

            return $artists;

        }

        /*
                 * find from slug
                 */
        if (isset($this->slug)) {
            $artists = Artist::query()->where('status', Artist::STATUS_ACTIVE)
                ->where('slug', $this->slug)->first();


            if ($this->toJson) {
                $artists = ArtistRepo::getInstance()->toJson()->setArtist($artists)->build();
            }

            return $artists;
        }
        return null;
    }

}
