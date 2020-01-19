<?php


namespace App\Http\Repositories\V1\Album;

class AlbumRepo implements Builder
{
    private static $instance = null;

    public static function getInstance(): AlbumRepo
    {
        if (self::$instance == null) {
            self::$instance = new AlbumRepo();
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

    public function toJsonArray(): ToJsonArray
    {
        return new ToJsonArray();
    }

    public function toJson(): toJson
    {
        return new ToJson();
    }
}
