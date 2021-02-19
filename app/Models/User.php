<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    const  Administrator = 1;

    const USER_STATUS_DEACTIVE = 0;
    const USER_STATUS_ACTIVE = 1;
    const USER_STATUS_NOT_VERIFY = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'level'
    ];

    protected $casts = [
        'global_notification' => 'boolean',
        'music_notification' => 'boolean',
        'album_notification' => 'boolean',
        'video_notification' => 'boolean',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin()
    {
        return $this->level == 'admin' ? true : false;
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }

    public function playlists()
    {
        return $this->hasMany(Playlist::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    public function notification()
    {
        return $this->hasMany(User::class);
    }

    public function histories()
    {
        return $this->hasMany(PlayHistory::class);
    }
}
