<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Browse extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    const TYPE_ARTISTS = 1;
    const TYPE_MUSICS = 2;
    const TYPE_ALBUMS = 3;
    const TYPE_PLAYLISTS = 4;
    const TYPE_PROMOTIONS = 5;
    const TYPE_ALBUM_MUSIC_GRID = 6;
    const TYPE_PLAYLIST_GRID = 7;
    const TYPE_MUSIC_GRID = 8;
    const TYPE_MUSIC_TRENDING = 9;
    const TYPE_VIDEOS = 10;
    const TYPE_MUSIC_VERTICAL = 11;
    const TYPE_FOR_YOU = 12;
    const TYPE_PLAY_HISTORY = 13;
    const TYPE_PLAY_FOLLOWS = 14;
    const TYPE_BROWSE_DOCK = 15;
    const TYPE_CLIENT_PLAYLISTS = 16;

    const SORT_LATEST = "latest";
    const SORT_BEST = "best";
    const SORT_OLDEST = "oldest";
}
