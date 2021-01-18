<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopArtist extends Model
{
    protected $guarded = ['id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
