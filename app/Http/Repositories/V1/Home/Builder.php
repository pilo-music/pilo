<?php

namespace App\Http\Repositories\V1\Home;

interface Builder
{
    public function find();

    public function get();

    public function toJsonArray();

    public function toJson();
}
