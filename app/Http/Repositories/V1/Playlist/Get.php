<?php


namespace App\Http\Repositories\V1\Playlist;


use App\Models\Artist;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Models\Playlist;
use Illuminate\Support\Collection;

class Get
{
    protected $count;
    protected $page;
    protected $sort;
    protected $artist;
    protected $user;
    protected $toJson;


    public function __construct()
    {
        $this->count = Playlist::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Playlist::SORT_LATEST;
        $this->artist = null;
        $this->user = null;
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
     * @param mixed $user
     * @return Get
     */
    public function setUser($user): Get
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection
     */
    public function build(): Collection
    {
        /**
         * @todo should make table playlist artist first
         */
//        if (isset($this->artist)) {
//            if (!$this->artist instanceof Artist) {
//                $this->artist = ArtistRepo::getInstance()->find()->setSlug($this->artist)->build();
//                if (!$this->artist)
//                    return collect([]);
//            }
//            $playlists = $this->artist->albums()->where('status', Playlist::STATUS_ACTIVE);
//        } else {
//            $playlists = Playlist::query()->where('status', Playlist::STATUS_ACTIVE);
//        }

        if (isset($this->user)) {
            $playlists = Playlist::query()->Where('user_id', $this->user->id)->where('status', Playlist::STATUS_ACTIVE);
        } else {
            $playlists = Playlist::query()->whereNull('user_id')->where('status', Playlist::STATUS_ACTIVE);
        }

        switch ($this->sort) {
            case Playlist::SORT_LATEST:
                $playlists = $playlists->latest();
                break;
            case  Playlist::SORT_BEST:
                $playlists = $playlists->orderBy('play_count');
                break;
        }

        $playlists = $playlists->skip(($this->page - 1) * $this->count)->take($this->count)->get();

        if ($this->toJson) {
            $playlists = PlaylistRepo::getInstance()->toJsonArray()->setPlaylists($playlists)->build();
        }

        return $playlists;
    }
}
