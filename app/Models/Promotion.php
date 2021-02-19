<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    const TYPE_MUSIC = 1;
    const TYPE_ALBUM = 2;
    const TYPE_ARTIST = 3;
    const TYPE_VIDEO = 4;
    const TYPE_PLAYLIST = 5;
    const TYPE_AD = 6;

    protected $guarded = ['id'];
}
