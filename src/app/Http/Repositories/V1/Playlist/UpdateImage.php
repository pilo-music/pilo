<?php


namespace App\Http\Repositories\V1\Playlist;


class UpdateImage
{
    protected $playlist;

    public function __construct()
    {
        $this->playlist = null;
    }

    /**
     * @param null $playlist
     * @return UpdateImage
     */
    public function setPlaylist($playlist): UpdateImage
    {
        $this->playlist = $playlist;
        return $this;
    }

    public function build()
    {
        if (isset($this->playlist)){
            $playlist = $this->playlist;
            $musics = $playlist->musics()->get();
            if ($musics->count() == 0) {
                $playlist->update([
                    'image_one' => env('APP_URL') . '/images/default-playlist.jpg',
                    'image_two' => "",
                    'image_three' => "",
                    'image_four' => "",
                ]);
            } elseif ($musics->count() == 1) {
                $playlist->update([
                    'image_one' => $musics[$musics->count() - 1]->image,
                    'image_two' => "",
                    'image_three' => "",
                    'image_four' => "",
                ]);
            } elseif ($musics->count() == 2) {
                $playlist->update([
                    'image_one' => $musics[$musics->count() - 1]->image,
                    'image_two' => $musics[$musics->count() - 2]->image,
                    'image_three' => $musics[$musics->count() - 1]->image,
                    'image_four' => $musics[$musics->count() - 2]->image,
                ]);
            } elseif ($musics->count() == 3) {
                $playlist->update([
                    'image_one' => $musics[$musics->count() - 1]->image,
                    'image_two' => $musics[$musics->count() - 2]->image,
                    'image_there' => $musics[$musics->count() - 3]->image,
                    'image_four' => env('APP_URL') . '/images/default-playlist.jpg',
                ]);
            } elseif ($musics->count() > 3) {
                $playlist->update([
                    'image_one' => $musics[$musics->count() - 1]->image,
                    'image_two' => $musics[$musics->count() - 2]->image,
                    'image_three' => $musics[$musics->count() - 3]->image,
                    'image_four' => $musics[$musics->count() - 4]->image,
                ]);
            }
        }
    }
}
