<?php


namespace App\Http\Repositories\V1\Album;


use App\Models\Album;
use App\Models\Artist;
use App\Http\Repositories\V1\Artist\ArtistRepo;

class Find
{
    protected $count;
    protected $page;
    protected $sort;
    protected $name;
    protected $slug;
    protected $artist;
    protected $toJson;


    public function __construct()
    {
        $this->count = Album::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Album::DEFAULT_ITEM_SORT;
        $this->name = null;
        $this->slug = null;
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
     * Set the value of name
     *
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


    /**
     * @return array|null|Album
     */
    public function build()
    {
        if (isset($this->artist)) {
            if (!$this->artist instanceof Artist) {
                $this->artist = ArtistRepo::getInstance()->find()->setSlug($this->artist)->build();
            }
        }

        if (isset($this->name) && !empty($this->name)) {
            /*
             *  find from name
             */
            $albums = Album::query()->where('name', 'LIKE', '%' . $this->name . '%')
                ->where('status', Album::STATUS_ACTIVE);

            if (isset($this->artist)) {
                $albums = $albums->where('artist_id', $this->artist->id);

                $tagAlbums = $this->artist->tagAlbums()->get();

                if (count($tagAlbums) > 0) {
                    $albums = $albums->merge($tagAlbums);
                }
            }

            switch ($this->sort) {
                case Album::SORT_LATEST:
                    $albums = $albums->latest();
                    break;
                case  Album::SORT_BEST:
                    return $albums->skip(($this->page - 1) * $this->count)->take($this->count)->get()->sortBy('play_count');
                    break;
            }

            $albums = $albums->skip(($this->page - 1) * $this->count)->take($this->count)->get();

            if ($this->toJson) {
                $albums = AlbumRepo::getInstance()->toJsonArray()->setAlbums($albums)->build();
            }

            return $albums;
        } else {
            /*
             * find from slug
             */
            if (isset($this->slug) && $this->slug != "") {
                $album = Album::where('status', Album::STATUS_ACTIVE)
                    ->where('slug', $this->slug)->first();

                if ($this->toJson) {
                    $album = AlbumRepo::getInstance()->toJson()->setAlbum($album)->build();
                }

                return $album;
            }
        }
        return null;
    }
}
