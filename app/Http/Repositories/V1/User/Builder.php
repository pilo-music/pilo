<?php

namespace App\Http\Repositories\V1\User;

interface Builder
{
    public function toJson();

    public function toJsonArray();
}
