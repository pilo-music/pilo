<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 0;
    const STATUS_JUST_IN_APP = 2;
    const STATUS_JUST_IN_WEB = 3;

    use Sluggable;

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
                'source' => 'title',
            ],
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function musics()
    {
        return $this->morphedByMany(Music::class,'playlistable');
    }
}
