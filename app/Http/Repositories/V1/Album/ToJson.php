<?php

namespace App\Http\Repositories\V1\Album;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use Illuminate\Support\Carbon;

class ToJson
{
    protected $album;

    public function __construct()
    {
        $this->album = null;
    }

    /**
     * Set the value of album
     *
     * @param $album
     * @return  self
     */
    public function setAlbum($album)
    {
        $this->album = $album;

        return $this;
    }

    public function build()
    {
        if ($this->album) {
            $slug = $this->album->slug;
            return [
                'slug' => $slug,
                'title' => $this->album->title_en == null ? "" : $this->album->title_en,
                'image' => get_image($this->album, 'image'),
                'thumbnail' => get_image($this->album, 'thumbnail'),
                'music_count' => $this->album->music_count == null ? 0 : $this->album->music_count,
                'like_count' => $this->album->like_count,
                'play_count' => $this->album->play_count,
                'artist' => ArtistRepo::getInstance()->toJson()->setArtist($this->album->artist)->build(),
                "share_url" => "https://pilo.app/share?slug={$slug}&type=album",
                'created_at' => Carbon::parse($this->album->created_at)->format('D d,Y'),
                'type' => 'album',
            ];
        }

        return null;
    }
}
