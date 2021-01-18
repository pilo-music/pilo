<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $guarded = ['id'];

    public function sourceable()
    {
        return $this->morphTo();
    }
}
