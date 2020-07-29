<?php

namespace App\Http\Repositories\V1\Music;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Models\Artist;
use App\Models\Music;
use App\Models\TopMusic;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Get
{
    protected $count;
    protected $page;
    protected $sort;
    protected $artist;
    protected $withAlbum;
    protected $withTags;
    protected $toJson;


    public function __construct()
    {
        $this->count = Music::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Music::SORT_LATEST;
        $this->artist = null;
        $this->toJson = false;
        $this->withAlbum = true;
        $this->withTags = false;
    }

    /**
     * Set the value of count
     *
     * @param $count
     * @return  self
     */
    public function setCount($count): self
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
    public function setPage($page): self
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
    public function setSort($sort): self
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
    public function setArtist($artist): self
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
    public function setToJson(bool $toJson = true): self
    {
        $this->toJson = $toJson;

        return $this;
    }

    /**
     * @param bool $withAlbum
     * @return Get
     */
    public function setWithAlbum(bool $withAlbum = true): Get
    {
        $this->withAlbum = $withAlbum;
        return $this;
    }

    /**
     * @param bool $withTags
     * @return Get
     */
    public function setWithTags(bool $withTags = true): Get
    {
        $this->withTags = $withTags;
        return $this;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Builder|HasMany
     */
    public function build()
    {
        if (isset($this->artist)) {
            if (!$this->artist instanceof Artist) {
                $this->artist = ArtistRepo::getInstance()->find()->setSlug($this->artist)->build();
                if (!$this->artist) {
                    return collect([]);
                }
            }
            $musics = $this->artist->musics()->where('status', Music::STATUS_ACTIVE);
        } else {
            $musics = Music::query()->where('status', Music::STATUS_ACTIVE);
        }

        if (!$this->withAlbum) {
            $musics = $musics->whereNull('album_id');
        }


        switch ($this->sort) {
            case Music::SORT_LATEST:
                $musics = $musics->latest();
                break;
            case  Music::SORT_BEST:
                if (isset($this->artist)) {
                    $musics = $this->getBestMusics($musics);
                } else {
                    return $this->getBestMusics($musics);
                }
                break;
        }


        if ($this->withTags && $this->artist) {
            if ($this->page > 1) {
                return collect([]);
            }

            $newMusicArray = [];

            foreach ($musics->get() as $item){
                $newMusicArray[] = $item;
            }
            foreach ($this->artist->tagMusics()->get() as $item){
                $newMusicArray[] = $item;
            }

            $musics = collect($newMusicArray)->unique();
        } else {
            $musics = $musics->skip(($this->page - 1) * $this->count)->take($this->count)->get();
        }

        if ($this->toJson) {
            $musics = MusicRepo::getInstance()->toJsonArray()->setMusics($musics)->build();
        }


        return $musics;
    }

    private function getBestMusics($musics)
    {
        if (isset($this->artist)) {
            $musics = $musics->orderBy('play_count');
        } else {
            $items = TopMusic::query()->skip(($this->page - 1) * $this->count)->take($this->count)->get();
            $musics = [];
            foreach ($items as $item) {
                if ($this->toJson) {
                    $musics[] = MusicRepo::getInstance()->toJson()->setMusic($item->music)->build();
                } else {
                    $musics[] = $item->music;
                }
            }
            return $musics;
        }

        return $musics;
    }
}
