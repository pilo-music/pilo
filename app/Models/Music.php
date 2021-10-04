<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * @property integer id
 * @property integer user_id
 * @property integer artist_id
 * @property integer album_id
 * @property string title
 * @property string title_en
 * @property string slug
 * @property string image
 * @property string text
 * @property string link128
 * @property string link320
 * @property boolean isbest
 * @property string time
 * @property integer like_count
 * @property integer play_count
 * @property string thumbnail
 *
 * @property Album album
 * @property Artist artist
 * @property Collection artists
 * @property Collection comments
 * @property Collection sources
 *
 */
class Music extends Model
{
    use Notifiable;
    use HasFactory;
    use Searchable;

    protected $table = "musics";

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


    public function path(): string
    {
        return "/music/$this->slug";
    }

    protected $guarded = [
        'id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
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
}
