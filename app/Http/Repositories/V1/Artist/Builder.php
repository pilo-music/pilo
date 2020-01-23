<?php

namespace App\Http\Repositories\V1\Artist;

interface Builder
{
    public function find();
    public function get();
    public function toJson();
    public function toJsonArray();
}
