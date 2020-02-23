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
        if (isset($this->artists)) {
            $return_info = [];
            foreach ($this->musics as $music) {
                $return_info[] = MusicRepo::getInstance()->toJsonArray()->setMusics($music)->build();
            }
            return $return_info;
        }
        return [];
    }
}
