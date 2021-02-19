<?php


namespace App\Http\Repositories\V1\Bookmark;


class BookmarkRepo implements Builder
{

    private static $instance = null;

    public static function getInstance(): BookmarkRepo
    {
        if (self::$instance == null) {
            self::$instance = new BookmarkRepo();
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
