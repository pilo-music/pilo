<?php


namespace App\Http\Repositories\V1\Home;


class HomeRepo implements Builder
{
    private static $instance = null;

    public static function getInstance(): HomeRepo
    {
        if (self::$instance == null) {
            self::$instance = new HomeRepo();
        }

        return self::$instance;
    }

    public function find()
    {
        return new Find();
    }

    public function get()
    {
        return new Get();
    }

    public function toJsonArray()
    {
        return new ToJsonArray();
    }

    public function toJson()
    {
        return new ToJson();
    }
}
