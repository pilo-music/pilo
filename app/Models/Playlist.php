<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Playlist extends Model
{
    use HasFactory, Searchable;

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

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function musics()
    {
        return $this->morphedByMany(Music::class, 'playlistable');
    }

    public function sources()
    {
        return $this->morphMany(Source::class, 'sourceable');
    }


    public function artists()
    {
        return $this->morphToMany(Artist::class, 'artistable');
    }
}
