<?php

namespace App\Http\Repositories\V1\Follow;

use App\Models\Follow;

class Has
{
    protected $user;
    protected $artist;

    public function __construct()
    {
        $this->user = null;
        $this->artist = null;
    }

    /**
     * @param null $artist
     * @return Has
     */
    public function setArtist($artist): Has
    {
        $this->artist = $artist;
        return $this;
    }

    /**
     * @param null $user
     * @return Has
     */
    public function setUser($user): Has
    {
        $this->user = $user;
        return $this;
    }

    public function build()
    {
        if ($this->user == null) {
            return false;
        }
        if ($this->user == null) {
            return false;
        }

        return Follow::query()->where('artist_id', $this->artist->id)
            ->where('user_id', $this->user->id)->exists();
    }
}
