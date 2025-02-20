<?php

namespace App\Http\Repositories\V1\Artist;

use App\Http\Repositories\V1\Music\MusicRepo;
use App\Models\Artist;
use App\Models\Music;
use App\Services\Search\Search;

class Find
{
    private Search $search;
    protected $columns;
    protected $name;
    protected $slug;
    protected $id;
    protected $count;
    protected $sort;
    protected $page;
    protected $toJson;

    public function __construct()
    {
        $this->search = new Search();
        $this->columns = ["*"];
        $this->name = null;
        $this->slug = null;
        $this->id = null;
        $this->count = Artist::DEFAULT_ITEM_COUNT;
        $this->sort = Artist::DEFAULT_ITEM_SORT;
        $this->page = 1;
        $this->toJson = false;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
        return $this;
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
            $items = $this->search->search(Search::INDEX_ARTIST, $this->name, $this->page, $this->count);
            $idList = collect($items)->pluck("id")->toArray();
            $artists = Artist::query()->select($this->columns)->where('status', Artist::STATUS_ACTIVE)
                ->whereIn('id', $idList)->get();

            if ($this->toJson) {
                $artists = ArtistRepo::getInstance()->toJsonArray()->setArtists($artists)->build();
            }

            return $artists;
        }

        if (isset($this->id)) {
            /**
             * find from id
             */
            $artists = Artist::query()->select($this->columns)->where('status', Artist::STATUS_ACTIVE)
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
            $artists = Artist::query()->select($this->columns)->where('status', Artist::STATUS_ACTIVE)
                ->where('slug', $this->slug)->first();


            if ($this->toJson) {
                $artists = ArtistRepo::getInstance()->toJson()->setArtist($artists)->build();
            }

            return $artists;
        }
        return null;
    }
}
