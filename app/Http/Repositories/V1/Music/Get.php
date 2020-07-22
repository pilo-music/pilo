<?php

namespace App\Http\Repositories\V1\Music;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Models\Artist;
use App\Models\Music;
use App\Models\TopMusic;
use Illuminate\Support\Collection;

class Get
{
    protected $count;
    protected $page;
    protected $sort;
    protected $artist;
    protected $toJson;


    public function __construct()
    {
        $this->count = Music::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Music::SORT_LATEST;
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
     * @return Collection
     */
    public function build(): Collection
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

        switch ($this->sort) {
            case Music::SORT_LATEST:
                $musics = $musics->latest();
                break;
            case  Music::SORT_BEST:
//                $musics = $musics->orderBy('play_count');
                $toJson = $this->toJson;
                $musics = TopMusic::query()->where('is_active', true)->limit($this->count)->get()->map(static function ($item) use ($toJson) {
                    if ($toJson) {
                        $item = MusicRepo::getInstance()->toJsonArray()->setMusics($item->music)->build();
                    } else {
                        $item = $item->music;
                    }
                    return $item;
                });

                return $musics;

                break;
        }

        $musics = $musics->skip(($this->page - 1) * $this->count)->take($this->count)->get();

        if ($this->toJson) {
            $musics = MusicRepo::getInstance()->toJsonArray()->setMusics($musics)->build();
        }

        return $musics;
    }
}
