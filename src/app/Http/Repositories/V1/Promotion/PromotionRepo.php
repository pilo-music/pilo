<?php


namespace App\Http\Repositories\V1\Promotion;


class PromotionRepo implements Builder
{

    private static $instance = null;

    public static function getInstance(): PromotionRepo
    {
        if (self::$instance == null) {
            self::$instance = new PromotionRepo();
        }

        return self::$instance;
    }

    public function find()
    {
        return new Find();
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
