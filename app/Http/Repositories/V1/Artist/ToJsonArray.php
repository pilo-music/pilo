<?php

namespace App\Http\Repositories\V1\Artist;

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
     * @return  self
     */
    public function setArtists($artists)
    {
        $this->artists = $artists;

        return $this;
    }


    public function build()
    {
        if (isset($this->artists)) {
            $return_info = [];
            foreach ($this->artists as $artist) {
                $return_info[] = ArtistRepo::getInstance()->toJsonArray()->setArtists($artist)->build();
            }
            return $return_info;
        }
        return [];
    }
}
