<?php

namespace App\Http\Repositories\V1\Music;

class ToJsonArray
{
    protected $musics;

    public function __construct()
    {
        $this->musics = null;
    }

    /**
     * Set the value of artists
     *
     * @param $musics
     * @return  self
     */
    public function setMusics($musics)
    {
        $this->musics = $musics;

        return $this;
    }


    public function build()
    {
        return $this->musics->map(function ($item) {
            return MusicRepo::getInstance()->toJson()->setMusic($item)->build();
        })->unique();
    }
}
