<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer id
 * @property string name
 * @property string level
 * @property string email
 * @property string phone
 * @property string birth
 * @property string gender
 * @property string pic
 * @property string password
 * @property integer status
 * @property string email_verified_at
 * @property string phone_verified_at
 *
 * @property Collection comments
 * @property Collection likes
 * @property Collection playlists
 * @property Collection messages
 * @property Collection follows
 * @property Collection notifications
 * @property Collection histories
 *
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;
    use HasFactory;

    public const  Administrator = 1;

    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;

    public const USER_STATUS_DEACTIVE = 0;
    public const USER_STATUS_ACTIVE = 1;
    public const USER_STATUS_NOT_VERIFY = 2;
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

    public function isAdmin(): bool
    {
        return $this->level === 'admin';
    }


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        return (bool)$role->intersect($this->roles)->count();
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function playlists(): HasMany
    {
        return $this->hasMany(Playlist::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function follows(): HasMany
    {
        return $this->hasMany(Follow::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(UserNotification::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(PlayHistory::class);
    }
}
