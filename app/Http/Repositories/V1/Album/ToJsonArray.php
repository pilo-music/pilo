<?php


namespace App\Http\Repositories\V1\Album;

use Illuminate\Support\Collection;

class ToJsonArray
{
    protected $albums;

    public function __construct()
    {
        $this->albums = collect([]);
    }

    /**
     * Set the value of albums
     *
     * @param $albums
     * @return  self
     */
    public function setAlbums(Collection $albums)
    {
        $this->albums = $albums;

        return $this;
    }

    public function build(): Collection
    {
        return $this->albums->map(function ($item) {
            return AlbumRepo::getInstance()->toJsonArray()->setAlbums($item)->build();
        });
    }
}
