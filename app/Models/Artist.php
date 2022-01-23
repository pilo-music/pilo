<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

/**
 * @property integer id
 * @property integer user_id
 * @property string name
 * @property string name_en
 * @property string slug
 * @property string image
 * @property boolean isbest
 * @property integer music_count
 * @property integer album_count
 * @property integer followers_count
 * @property integer playlist_count
 * @property integer video_count
 * @property string header_image
 * @property string thumbnail
 *
 * @property User user
 * @property Collection musics
 * @property Collection albums
 * @property Collection videos
 * @property Collection tagMusics
 * @property Collection tagAlbums
 * @property Collection tagVideos
 * @property Collection tagPlaylists
 * @property Collection sources
 * @property Collection follows
 *
 */
class Artist extends Model
{
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

    use HasFactory;

    protected $guarded = [];

    public function scopeActive($query)
    {
        $query->where('status', self::STATUS_ACTIVE);
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function musics(): HasMany
    {
        return $this->hasMany(Music::class);
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }


    public function tagMusics(): MorphToMany
    {
        return $this->morphedByMany(Music::class, 'artistable');
    }

    public function tagAlbums(): MorphToMany
    {
        return $this->morphedByMany(Album::class, 'artistable');
    }

    public function tagVideos(): MorphToMany
    {
        return $this->morphedByMany(Video::class, 'artistable');
    }

    public function tagPlaylists(): MorphToMany
    {
        return $this->morphedByMany(Playlist::class, 'artistable');
    }

    public function sources(): MorphMany
    {
        return $this->morphMany(Source::class, 'sourceable');
    }

    public function follows(): HasMany
    {
        return $this->hasMany(Follow::class);
    }
}
