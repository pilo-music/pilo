<?php


namespace App\Http\Repositories\V1\Follow;


class FollowRepo implements Builder
{

    private static $instance = null;

    public static function getInstance(): FollowRepo
    {
        if (self::$instance == null) {
            self::$instance = new FollowRepo();
        }

        return self::$instance;
    }
    /**
     * @return Has
     */
    public function has() : Has
    {
        return new Has();
    }
}
