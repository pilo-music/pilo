<?php

namespace App\Http\Repositories\V1\Video;

interface Builder
{
    public function find();

    public function get();

    public function random();

    public function toJson();

    public function toJsonArray();
}
