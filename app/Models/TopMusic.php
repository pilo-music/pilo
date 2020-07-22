<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopMusic extends Model
{
    protected $guarded = ['id'];

    public function music()
    {
        return $this->belongsTo(Music::class);
    }
}
