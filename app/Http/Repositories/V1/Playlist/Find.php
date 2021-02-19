<?php


namespace App\Http\Repositories\V1\Playlist;


use App\Models\Album;
use App\Models\Playlist;

class Find
{
    protected $count;
    protected $page;
    protected $sort;
    protected $id;
    protected $name;
    protected $slug;
    protected $artist;
    protected $toJson;
    protected $user;


    public function __construct()
    {
        $this->count = Playlist::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Playlist::DEFAULT_ITEM_SORT;
        $this->name = null;
        $this->slug = null;
        $this->artist = null;
        $this->toJson = false;
        $this->id = null;
        $this->user = null;
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
     * @param mixed $user
     * @return Find
     */
    public function setUser($user): Find
    {
        $this->user = $user;
        return $this;
    }


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

        if (!isset($this->id) && !isset($this->slug) && !isset($this->name)) {
            return null;
        }

        if (isset($this->name)) {
            /**
             *  find from name
             */
            $playlist = Playlist::search($this->name)
                ->where('status', Playlist::STATUS_ACTIVE)
                ->paginate($this->count, 'page', $this->page);

            if ($this->toJson) {
                $playlist = PlaylistRepo::getInstance()->toJsonArray()->setPlaylists($playlist)->build();
            }

            return $playlist;
        }

        if (isset($this->id)) {

            $playlist = Playlist::query()->where('status', Playlist::STATUS_ACTIVE)
                ->where('id', $this->id)->first();

            $playlist = $this->checkUser($playlist);

            if ($this->toJson) {
                $playlist = PlaylistRepo::getInstance()->toJson()->setPlaylist($playlist)->build();
            }

            return $playlist;

        }

        $playlist = Playlist::query()->where('status', Playlist::STATUS_ACTIVE)
            ->where('slug', $this->slug)->first();

        $playlist = $this->checkUser($playlist);

        if ($this->toJson) {
            $playlist = PlaylistRepo::getInstance()->toJson()->setPlaylist($playlist)->build();
        }

        return $playlist;
    }

    /**
     * check playlist user
     * @param $playlist
     * @return mixed
     */
    private function checkUser($playlist)
    {
        if ($playlist && $playlist->user_id != null) {
            if (isset($this->user) && $this->user->id == $playlist->user_id) {
                return $playlist;
            }
            return null;
        }
        return $playlist;
    }
}
