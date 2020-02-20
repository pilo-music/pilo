<?php


namespace App\Http\Repositories\V1\Album;

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

    public function build(): array
    {
        if ($this->album) {
            return [
                'id' => $this->album->id,
                'name' => $this->album->name == null ? "" : $this->album->name,
                'description' => $this->album->description == null ? "" : $this->album->description,
                'image' => get_image($this->album, 'image'),
                'thumbnail' => get_image($this->album, 'thumbnail'),
                'music_count' => $this->album->music_count == null ? 0 : $this->album->music_count,
                'duration' => $this->album->duration,
                'likes' => $this->album->like_count,
                'dislikes' => $this->album->dislike_count,
                'created_at' => $this->album->created_at,
                'play_count' => $this->album->play_count == null ? 0 : $this->album->play_count,
                'artist' => $this->album->artist->name,
                'type' => 'album'
            ];
        }
    }
}
