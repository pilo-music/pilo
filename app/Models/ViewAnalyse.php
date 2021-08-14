<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewAnalyse extends Model
{
    protected $guarded = ['id'];
    public const POST_TYPE_MUSIC = 0;
    public const POST_TYPE_ARTIST = 1;
    public const POST_TYPE_MUSIC_VIDEO = 2;
    public const POST_TYPE_ALBUM = 3;
    public const POST_TYPE_INDEX = 5;
}
