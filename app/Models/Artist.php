<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    const SORT_LATEST = "latest";
    const SORT_BEST = "best";
    const SORT_OLDEST = "oldest";
    const SORT_SEARCH = "search";

    const DEFAULT_ITEM_COUNT = 12;
    const DEFAULT_ITEM_SORT = self::SORT_LATEST;

    protected $guarded = [
        'id'
    ];


    public function path()
    {
        return "/artist/$this->slug";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function musics()
    {
        return $this->hasMany(Music::class);
    }

    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }


    public function tagMusics()
    {
        return $this->morphedByMany(Music::class, 'artistable');
    }

    public function tagAlbums()
    {
        return $this->morphedByMany(Album::class, 'artistable');
    }

    public function tagVideos()
    {
        return $this->morphedByMany(Video::class, 'artistable');
    }

    public function tagPlaylist()
    {
        return $this->morphedByMany(Playlist::class, 'artistable');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }
}
