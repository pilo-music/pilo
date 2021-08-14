<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Browse extends Model
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_DRAFT = 0;
    public const STATUS_JUST_IN_APP = 2;
    public const STATUS_JUST_IN_WEB = 3;

    public const TYPE_ARTISTS = 1;
    public const TYPE_MUSICS = 2;
    public const TYPE_ALBUMS = 3;
    public const TYPE_PLAYLISTS = 4;
    public const TYPE_PROMOTIONS = 5;
    public const TYPE_ALBUM_MUSIC_GRID = 6;
    public const TYPE_PLAYLIST_GRID = 7;
    public const TYPE_MUSIC_GRID = 8;
    public const TYPE_MUSIC_TRENDING = 9;
    public const TYPE_VIDEOS = 10;
    public const TYPE_MUSIC_VERTICAL = 11;
    public const TYPE_FOR_YOU = 12;
    public const TYPE_PLAY_HISTORY = 13;
    public const TYPE_PLAY_FOLLOWS = 14;
    public const TYPE_BROWSE_DOCK = 15;
    public const TYPE_CLIENT_PLAYLISTS = 16;

    public const SORT_LATEST = "latest";
    public const SORT_BEST = "best";
    public const SORT_OLDEST = "oldest";
}
