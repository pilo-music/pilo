<?php

namespace App\Http\Repositories\V1\Album;

use App\Models\Album;
use App\Models\Artist;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Services\Search\Search;
use Illuminate\Database\Eloquent\Collection;

class Find
{
    private Search $search;
    protected $columns;
    protected $count;
    protected $page;
    protected $sort;
    protected $name;
    protected $id;
    protected $slug;
    protected $artist;
    protected $toJson;


    public function __construct()
    {
        $this->search = new Search();
        $this->columns = ["*"];
        $this->count = Album::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Album::DEFAULT_ITEM_SORT;
        $this->name = null;
        $this->slug = null;
        $this->artist = null;
        $this->toJson = false;
        $this->id = null;
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
     * Set the value of sort
     *
     * @param $sort
     * @return  self
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

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
     * Set the value of artist
     *
     * @param $artist
     * @return  self
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

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
     * @param mixed $id
     * @return Find
     */
    public function setId($id): Find
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return array|null|Collection
     */
    public function build()
    {
        if (isset($this->artist)) {
            if (!$this->artist instanceof Artist) {
                $this->artist = ArtistRepo::getInstance()->find()->setSlug($this->artist)->build();
            }

            if (!$this->artist) {
                return null;
            }
        }

        if (isset($this->name) && !empty($this->name)) {
            /*
            *  find from name
            */
            $items = $this->search->search(Search::INDEX_ALBUMS, $this->name, $this->page, $this->count);
            $idList = collect($items)->pluck("id")->toArray();
            $albums = Album::query()->select($this->columns)->where('status', Album::STATUS_ACTIVE)
                ->whereIn('id', $idList)->get();

            if ($this->toJson) {
                $albums = AlbumRepo::getInstance()->toJsonArray()->setAlbums($albums)->build();
            }

            return $albums;
        }

        if (isset($this->id)) {
            $album = Album::query()->select($this->columns)->where('status', Album::STATUS_ACTIVE)
                ->where('id', $this->id)->first();

            if ($this->toJson) {
                $album = AlbumRepo::getInstance()->toJson()->setAlbum($album)->build();
            }

            return $album;
        }

        /**
         * find from slug
         */
        if (isset($this->slug) && $this->slug != "") {
            $album = Album::query()->select($this->columns)->where('status', Album::STATUS_ACTIVE)
                ->where('slug', $this->slug)->first();

            if ($this->toJson) {
                $album = AlbumRepo::getInstance()->toJson()->setAlbum($album)->build();
            }

            return $album;
        }
        return null;
    }
}
