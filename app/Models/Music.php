<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Music extends Model implements AuditableContract
{
    use Auditable;
    use Notifiable;
    use Sluggable;

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    const SORT_LATEST = "latest";
    const SORT_BEST = "best";
    const SORT_OLDEST = "oldest";

    const DEFAULT_ITEM_COUNT = 12;
    const DEFAULT_ITEM_SORT = self::SORT_LATEST;

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'fullname',
            ],
        ];
    }

    public function getFullnameAttribute()
    {
        return $this->artist->name . '-' . $this->title;
    }


    public function path()
    {
        return "/music/$this->slug";
    }

    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function album()
    {
        return $this->belongsTo(Album::class);
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

    public function bookmarks()
    {
        return $this->morphMany(Bookmark::class, "bookmarkable");
    }
}
