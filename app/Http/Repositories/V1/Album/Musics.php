<?php


namespace App\Http\Repositories\V1\Album;


use App\Http\Repositories\V1\Music\MusicRepo;

class Musics
{
    protected $album;
    protected $toJson;

    public function __construct()
    {
        $this->album = null;
        $this->toJson = false;
    }

    /**
     * @param null $album
     * @return Musics
     */
    public function setAlbum($album): Musics
    {
        $this->album = $album;
        return $this;
    }

    /**
     * @param bool $toJson
     * @return Musics
     */
    public function setToJson(bool $toJson = true): Musics
    {
        $this->toJson = $toJson;
        return $this;
    }

    public function build()
    {
        if (isset($album)) {
            return MusicRepo::getInstance()->toJsonArray()->setMusics($album->musics()->get())->build;
        }
        return [];
    }
}
