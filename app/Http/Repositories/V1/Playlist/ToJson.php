<?php


namespace App\Http\Repositories\V1\Playlist;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\User\UserRepo;
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

    public function build()
    {
        if ($this->playlist) {
            return [
                'slug' => $this->playlist->slug,
                'title' => $this->playlist->title == null ? "" : $this->playlist->title,
                'image' => get_image($this->playlist, 'image'),
                'image_one' => get_image($this->playlist, 'image_one'),
                'image_two' => get_image($this->playlist, 'image_two'),
                'image_three' => get_image($this->playlist, 'image_three'),
                'image_four' => get_image($this->playlist, 'image_four'),
                'music_count' => $this->playlist->music_count,
                'like_count' => $this->playlist->like_count,
                'play_count' => $this->playlist->play_count,
                "share_url" => "https://pilo.app/playlist/" . $this->playlist->slug,
                'created_at' => Carbon::parse($this->playlist->created_at)->format('D d,Y'),
                'user' => $this->playlist->user_id ? UserRepo::getInstance()->toJson()->setUser($this->playlist->user)->build() : "",
                'type' => 'playlist'
            ];
        }

        return null;
    }
}
