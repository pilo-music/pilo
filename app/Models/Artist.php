<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Artist extends Model  implements AuditableContract
{
    use Auditable;
    use Sluggable;

    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;


    protected $guarded = [
        'id'
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

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

}
