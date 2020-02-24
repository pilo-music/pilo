<?php


namespace App\Http\Repositories\V1\Playlist;

use Illuminate\Support\Carbon;

class ToJson
{
    protected $playlist;

    public function __construct()
    {
        $this->playlist = null;
    }

    /**
     * Set the value of playlist
     *
     * @param $playlist
     * @return  self
     */
    public function setPlaylist($playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function build(): array
    {
        if ($this->playlist) {
            return [
                'slug' => $this->playlist->slug,
                'name' => $this->playlist->title == null ? "" : $this->playlist->title,
                'image' => get_image($this->playlist, 'image'),
                'thumbnail' => get_image($this->playlist, 'thumbnail'),
                'music_count' => $this->playlist->music_count == null ? 0 : $this->playlist->music_count,
                'like_count' => $this->playlist->like_count,
                'created_at' => Carbon::parse($this->playlist->created_at)->format('D d,Y'),
                'play_count' => $this->playlist->play_count,
//                'artist' => $this->playlist->artist->name,
                'type' => 'playlist'
            ];
        }
    }
}
