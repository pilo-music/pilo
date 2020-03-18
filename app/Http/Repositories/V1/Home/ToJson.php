<?php

namespace App\Http\Repositories\V1\Home;

use App\Models\Album;
use App\Models\Music;

class ToJson
{
    protected $artist;
    protected  $client;

    public function __construct()
    {
        $this->artist = null;
        $this->client = null;
    }

    /**
     * Set the value of artist
     *
     * @return  self
     */
    public function setArtist($artist)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Set the value of client
     *
     * @param $client
     * @return  self
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    public function build()
    {
        if (isset($this->artist)) {
            return [
                'slug' => $this->artist->slug,
                'name' => $this->artist->name == null ? "" : $this->artist->name,
                'image' => get_image($this->artist, 'image'),
                'thumbnail' => get_image($this->artist, 'thumbnail'),
                'header_image' => get_image($this->artist, 'header_image'),
                'music_count' => $this->artist->musics()->where('status', Music::STATUS_ACTIVE)->get()->count(),
                'album_count' => $this->artist->albums()->where('status', Album::STATUS_ACTIVE)->get()->count(),
                'created_at' => date('Y-m-d', strtotime($this->artist->created_at)),
                'region' => $this->artist->region == null ? "" : $this->artist->region,
//                'followers_count' => $this->artist->followers_count,
                'type' => 'artist',
//                'is_follow' => FollowRepoImpl::isFollow($this->client->id, $this->artist),
//                'playlist_count' => count(PlaylistRepoImpl::artistPlaylist($this->artist))
            ];
        }
    }
}
