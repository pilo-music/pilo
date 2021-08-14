<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    public const TYPE_URL = 1;
    public const TYPE_MUSIC = 2;
    public const TYPE_ALBUM = 3;
    public const TYPE_PLAYLIST = 4;
    public const TYPE_ARTIST = 5;
    public const TYPE_VIDEO = 6;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
