<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewAnalyse extends Model
{
    protected $guarded = ['id'];
    const POST_TYPE_MUSIC = 0;
    const POST_TYPE_ARTIST = 1;
    const POST_TYPE_MUSIC_VIDEO = 2;
    const POST_TYPE_ALBUM = 3;
    const POST_TYPE_INDEX = 5;
}
