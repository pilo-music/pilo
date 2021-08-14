<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_DRAFT = 0;
    public const STATUS_JUST_IN_APP = 2;
    public const STATUS_JUST_IN_WEB = 3;

    public const TYPE_MUSIC = 1;
    public const TYPE_ALBUM = 2;
    public const TYPE_ARTIST = 3;
    public const TYPE_VIDEO = 4;
    public const TYPE_PLAYLIST = 5;
    public const TYPE_AD = 6;

    protected $guarded = ['id'];
}
