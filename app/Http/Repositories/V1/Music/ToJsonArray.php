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
        $items = [];

        foreach ($this->musics as $music) {
            $item = MusicRepo::getInstance()->toJson()->setMusic($music)->build();
            if (!in_array($item, $items)) {
                $items[] = $item;
            }
        }

        return $items;
    }
}
