<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    const TYPE_URL = 1;
    const TYPE_MUSIC = 2;
    const TYPE_ALBUM = 3;
    const TYPE_PLAYLIST = 4;
    const TYPE_ARTIST = 5;
    const TYPE_VIDEO = 6;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
