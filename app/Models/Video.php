<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Video extends Model  implements AuditableContract
{
    use Auditable;
    use Sluggable;

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    protected $guarded = ['id'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'fullname'
            ]
        ];
    }

    public function getFullnameAttribute()
    {
        return $this->artist->name . '-' . $this->title;
    }

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

    public function tags()
    {
        return $this->morphMany(Tag::class, 'tagable');
    }
}
