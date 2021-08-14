<?php

namespace App\Http\Repositories\V1\Video;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Video;
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
        $this->count = Video::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Video::SORT_LATEST;
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
            $videos = $this->artist->videos()->where('status', Video::STATUS_ACTIVE);
        } else {
            $videos = Video::query()->where('status', Video::STATUS_ACTIVE);
        }

        switch ($this->sort) {
            case Video::SORT_LATEST:
                $videos = $videos->latest();
                break;
            case  Video::SORT_BEST:
                $videos = $videos->orderBy('play_count');
                break;
        }

        $videos = $videos->skip(($this->page - 1) * $this->count)->take($this->count)->get();

        if ($this->toJson) {
            $videos = VideoRepo::getInstance()->toJsonArray()->setVideos($videos)->build();
        }

        return $videos;
    }
}
