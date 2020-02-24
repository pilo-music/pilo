<?php


namespace App\Http\Repositories\V1\Playlist;


use App\Models\Album;
use App\Models\Playlist;

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
        $this->count = Playlist::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Playlist::DEFAULT_ITEM_SORT;
        $this->name = null;
        $this->slug = null;
        $this->artist = null;
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
     * @return array|null|Album
     */
    public function build()
    {
        /**
         * @todo should make table playlist artist first
         */
//        if (isset($this->artist)) {
//            if (!$this->artist instanceof Artist) {
//                $this->artist = ArtistRepo::getInstance()->find()->setSlug($this->artist)->build();
//            }
//
//            if (!$this->artist)
//                return null;
//        }

        if (isset($this->name) && !empty($this->name)) {
            /*
             *  find from name
             */
            $playlists = Playlist::query()->where('name', 'LIKE', '%' . $this->name . '%')
                ->where('status', Playlist::STATUS_ACTIVE);

            if (isset($this->artist)) {
                $playlists = $playlists->where('artist_id', $this->artist->id);

                $tagAlbums = $this->artist->tagAlbums()->get();

                if (count($tagAlbums) > 0) {
                    $playlists = $playlists->merge($tagAlbums);
                }
            }

            switch ($this->sort) {
                case Playlist::SORT_LATEST:
                    $playlists = $playlists->latest();
                    break;
                case  Playlist::SORT_BEST:
                    return $playlists->skip(($this->page - 1) * $this->count)->take($this->count)->get()->sortBy('play_count');
                    break;
            }

            $playlists = $playlists->skip(($this->page - 1) * $this->count)->take($this->count)->get();

            if ($this->toJson) {
                $playlists = PlaylistRepo::getInstance()->toJsonArray()->setAlbums($playlists)->build();
            }

            return $playlists;
        } else {
            /*
             * find from slug
             */
            if (isset($this->slug) && $this->slug != "") {
                $playlist = Playlist::query()->where('status', Playlist::STATUS_ACTIVE)
                    ->where('slug', $this->slug)->first();

                if ($this->toJson) {
                    $playlist = PlaylistRepo::getInstance()->toJson()->setAlbum($playlist)->build();
                }

                return $playlist;
            }
        }
        return null;
    }
}
