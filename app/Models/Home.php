<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    protected $guarded = ['id'];

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    const TYPE_ARTISTS = 1;
    const TYPE_MUSICS = 2;
    const TYPE_ALBUMS = 3;
    const TYPE_PLAYLISTS = 4;
    const TYPE_PROMOTIONS = 5;
    const TYPE_ALBUM_MUSIC_GRID = 7;
    const TYPE_PLAYLIST_GRID = 8;
    const TYPE_MUSIC_GRID = 9;
    const TYPE_MUSIC_TRENDING = 10;
    const TYPE_VIDEOS = 11;
    const TYPE_MUSIC_VERTICAL = 12;

    const SORT_LATEST = "latest";
    const SORT_BEST = "best";
    const SORT_OLDEST = "oldest";

}
