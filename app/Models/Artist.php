<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Artist extends Model
{
    use Searchable, HasFactory;

    public const STATUS_ACTIVE = 1;
    public const STATUS_DRAFT = 0;
    public const STATUS_JUST_IN_APP = 2;
    public const STATUS_JUST_IN_WEB = 3;

    public const SORT_LATEST = "latest";
    public const SORT_BEST = "best";
    public const SORT_OLDEST = "oldest";
    public const SORT_SEARCH = "search";

    public const DEFAULT_ITEM_COUNT = 12;
    public const DEFAULT_ITEM_SORT = self::SORT_LATEST;

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

    public function sources()
    {
        return $this->morphMany(Source::class, 'sourceable');
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }
}
