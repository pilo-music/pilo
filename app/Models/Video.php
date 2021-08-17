<?php

namespace App\Models;

use App\Search\VideoIndexConfigurator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $indexConfigurator = VideoIndexConfigurator::class;

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


    public function path()
    {
        return "/video/$this->slug";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function artists()
    {
        return $this->morphToMany(Artist::class, 'artistable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function sources()
    {
        return $this->morphMany(Source::class, 'sourceable');
    }
}
