<?php

namespace App\Http\Repositories\V1\Like;

class LikeRepo implements Builder
{
    private static $instance = null;

    public static function getInstance(): LikeRepo
    {
        if (self::$instance == null) {
            self::$instance = new LikeRepo();
        }

        return self::$instance;
    }
    /**
     * @return Has
     */
    public function has(): Has
    {
        return new Has();
    }
}
