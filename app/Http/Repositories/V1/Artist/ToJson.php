<?php

namespace App\Http\Repositories\V1\Artist;

class ToJson
{
    protected $artist;

    public function __construct()
    {
        $this->artist = null;
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
                'video_count' => $this->artist->music_count,
                'followers_count' => $this->artist->followers_count,
                'playlist_count' => $this->artist->playlist_count,
                "share_url" => "https://pilo.app/artist/".$this->artist->slug,
                'created_at' => date('Y-m-d', strtotime($this->artist->created_at)),
                'type' => 'artist',
            ];
        }
        return null;
    }
}
