<?php


namespace App\Http\Repositories\V1\Album;


use App\Models\Album;
use App\Models\Artist;
use App\Http\Repositories\V1\Artist\ArtistRepo;

class Get
{
    protected $count;
    protected $page;
    protected $sort;
    protected $artist;
    protected $toJson;


    public function __construct()
    {
        $this->count = Album::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Album::SORT_LATEST;
        $this->artist = null;
        $this->toJson = false;
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
     * Set the value of artist
     *
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
     * @return  self
     */
    public function setToJson(bool $toJson = true)
    {
        $this->toJson = $toJson;

        return $this;
    }

    public function build()
    {
        if (isset($this->artist)) {
            if (!$this->artist instanceof Artist) {
                $this->artist = ArtistRepo::getInstance()->find()->setSlug($this->artist)->build();
                if (!$this->artist)
                    return null;
            }
            $album = $this->artist->albums()->where('status', Album::STATUS_ACTIVE);
        } else {
            $album = Album::query()->where('status', Album::STATUS_ACTIVE);
        }

        switch ($this->type) {
            case Album::SORT_LATEST:
                $album = $album->latest();
                break;
            case  Album::SORT_BEST:
                return $album->skip(($this->page - 1) * $this->count)->take($this->count)->get()->sortBy('play_count');
                break;
        }

        $album = $album->skip(($this->page - 1) * $this->count)->take($this->count)->get();

        if ($this->toJson) {
            $album = AlbumRepo::getInstance()->toJsonArray()->setAlbums($album)->build();
        }

        return $album;
    }
}
