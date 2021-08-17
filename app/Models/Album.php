<?php

namespace App\Models;

use App\Search\AlbumIndexConfigurator;
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
 * @property integer artist_id
 * @property string title
 * @property string title_en
 * @property string slug
 * @property string image
 * @property boolean isbest
 * @property integer like_count
 * @property integer play_count
 * @property integer music_count
 * @property string thumbnail
 *
 * @property User user
 * @property Artist artist
 * @property Collection artists
 * @property Collection comments
 * @property Collection sources
 * @property Collection musics
 */
class Album extends Model
{
    use HasFactory;

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

    public function path(): string
    {
        return "/album/$this->slug";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function artists(): MorphToMany
    {
        return $this->morphToMany(Artist::class, 'artistable');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function sources(): MorphMany
    {
        return $this->morphMany(Source::class, 'sourceable');
    }

    public function musics(): HasMany
    {
        return $this->hasMany(Music::class);
    }
}
