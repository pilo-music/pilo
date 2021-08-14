<?php

namespace App\Http\Repositories\V1\Album;

interface Builder
{
    public function find();

    public function get();

    public function musics();

    public function random();

    public function toJsonArray();

    public function toJson();
}
