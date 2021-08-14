<?php

namespace App\Http\Repositories\V1\Playlist;

use Illuminate\Support\Collection;

class ToJsonArray
{
    protected $playlists;

    public function __construct()
    {
        $this->playlists = collect([]);
    }

    /**
     * Set the value of playlists
     *
     * @param  $playlists
     * @return  self
     */
    public function setPlaylists($playlists)
    {
        $this->playlists = $playlists;

        return $this;
    }

    public function build()
    {
        return $this->playlists->map(function ($item) {
            return PlaylistRepo::getInstance()->toJson()->setPlaylist($item)->build();
        })->unique();
    }
}
