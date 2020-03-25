<?php

namespace App\Http\Repositories\V1\Artist;

use App\Http\Repositories\V1\Follow\FollowRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Models\Album;
use App\Models\Music;

class ToJson
{
    protected $artist;
    protected $user;

    public function __construct()
    {
        $this->artist = null;
        $this->user = null;
    }

    /**
     * Set the value of artist
     *
     * @param $artist
     * @return  self
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Set the value of user
     *
     * @param $user
     * @return  self
     */
    public function setuser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function build()
    {
        if (isset($this->artist)) {
            return [
                'slug' => $this->artist->slug,
                'name' => $this->artist->name ?? "",
                'image' => get_image($this->artist, 'image'),
                'thumbnail' => get_image($this->artist, 'thumbnail'),
                'music_count' => $this->artist->music_count,
                'album_count' => $this->artist->album_count,
                'followers_count' => $this->artist->followers_count,
                'playlist_count' => $this->artist->playlist_count,
                'is_follow' => FollowRepo::getInstance()->has()->setArtist($this->artist)->setUser($this->user)->build(),
                'created_at' => date('Y-m-d', strtotime($this->artist->created_at)),
                'type' => 'artist',
            ];
        }
        return null;
    }
}
