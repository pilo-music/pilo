<?php

namespace App\Http\Repositories\V1\Playlist;

class PlaylistRepo implements Builder
{
    private static $instance = null;

    public static function getInstance(): PlaylistRepo
    {
        if (self::$instance == null) {
            self::$instance = new PlaylistRepo();
        }

        return self::$instance;
    }


    public function find(): Find
    {
        return new Find();
    }

    public function get(): Get
    {
        return new Get();
    }

    public function musics(): Musics
    {
        return new Musics();
    }

    public function random(): Random
    {
        return new Random();
    }

    public function updateImage(): UpdateImage
    {
        return new UpdateImage();
    }

    public function toJsonArray(): ToJsonArray
    {
        return new ToJsonArray();
    }

    public function toJson(): toJson
    {
        return new ToJson();
    }
}
