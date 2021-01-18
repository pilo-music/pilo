<?php


namespace App\Http\Repositories\V1\User;


class UserRepo implements Builder
{

    private static $instance = null;

    public static function getInstance(): UserRepo
    {
        if (self::$instance == null) {
            self::$instance = new UserRepo();
        }

        return self::$instance;
    }

    public function toJson()
    {
        return new ToJson();
    }

    public function toJsonArray()
    {
        return new ToJsonArray();
    }
}
