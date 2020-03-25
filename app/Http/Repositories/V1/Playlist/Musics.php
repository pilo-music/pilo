<?php


namespace App\Http\Repositories\V1\Playlist;


use App\Http\Repositories\V1\Music\MusicRepo;

class Musics
{
    protected $playlist;
    protected $toJson;

    public function __construct()
    {
        $this->playlist = null;
        $this->toJson = false;
    }

    /**
     * @param $playlist
     * @return Musics
     */
    public function setPlaylist($playlist): Musics
    {
        $this->playlist = $playlist;
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
        if (isset($playlists)) {
            return MusicRepo::getInstance()->toJsonArray()->setMusics($playlists->musics()->get())->build();
        }
        return [];
    }
}
