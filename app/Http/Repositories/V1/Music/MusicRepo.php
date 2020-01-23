<?php

namespace App\Http\Repositories\V1\Music;

class MusicRepo implements Builder
{
    private static $instance = null;

    public static function getInstance(): MusicRepo
    {
        if (self::$instance == null) {
            self::$instance = new MusicRepo();
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

    public function random(): Random
    {
        return new Random();
    }

    public function toJson(): ToJson
    {
        return new ToJson();
    }

    public function toJsonArray(): ToJsonArray
    {
        return new ToJsonArray();
    }
}
