<?php


namespace App\Http\Repositories\V1\Album;

use App\Models\Album;

class ToJsonArray
{
    protected $albums;

    public function __construct()
    {
        $this->albums = null;
    }

    /**
     * Set the value of albums
     *
     * @return  self
     */
    public function setAlbums($albums)
    {
        $this->albums = $albums;

        return $this;
    }

    public function build(): array
    {
        if (isset($this->albums)) {
            $return_info = [];
            foreach ($this->albums as $album) {
                $return_info[] = AlbumRepo::getInstance()->toJsonArray()->setAlbums($album)->build();
            }
            return $return_info;
        }
        return [];
    }
}
