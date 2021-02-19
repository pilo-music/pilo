<?php


namespace App\Http\Repositories\V1\Promotion;


interface Builder
{
    public function find();

    public function toJson();

    public function toJsonArray();
}
