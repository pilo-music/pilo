<?php

namespace App\Http\Repositories\V1\Playlist;

interface Builder
{
    public function find();

    public function get();

    public function musics();

    public function random();

    public function updateImage();

    public function toJsonArray();

    public function toJson();
}
