<?php

namespace App\Http\Repositories\V1\Home;

class ToJsonArray
{
    protected $artists;

    public function __construct()
    {
        $this->artists = null;
    }

    /**
     * Set the value of artists
     *
     * @param $artists
     * @return  self
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;

        return $this;
    }


    public function build()
    {
        return $this->artists->map(function ($item) {
            return ArtistRepo::getInstance()->toJson()->setArtist($item)->build();
        });
    }
}
