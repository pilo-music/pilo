<?php


namespace App\Http\Repositories\V1\Album;


use App\Models\Album;
use App\Models\Artist;

class Get
{
    protected $count;
    protected $page;
    protected $sort;
    protected $artist;

    public function __construct()
    {
        $this->count = Album::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Album::SORT_LATEST;
        $this->artist = null;
    }

    public function count(int $count)
    {
        $this->count = $count;
        return $this;
    }

    public function page(int $page)
    {
        $this->page = $page;
        return $this;
    }

    public function sort(string $sort)
    {
        $this->sort = $sort;
        return $this;
    }

    public function artist($artist)
    {
        $this->artist = $artist;
        return $this;
    }

    public function get($type, $artist, $count = 12, $page = 1, $region = null)
    {
        if (isset($artist)) {
            if (!$artist instanceof Artist) {
                $artist = Artist::find($artist);
                if (!$artist)
                    return null;
            }
            $album = $artist->albums()->where('status', Album::STATUS_ACTIVE);
        } else {
            $album = Album::where('status', Album::STATUS_ACTIVE);
        }

        if (isset($region))
            $album = $album->where('region', $region);

        switch ($type) {
            case Album::TYPE_LATEST:
                $album = $album->latest();
                break;
            case  Album::TYPE_BEST:
                return $album->skip(($page - 1) * $count)->take($count)->get()->sortBy('play_count');
                break;
        }

        $album = $album->skip(($page - 1) * $count)->take($count)->get();

        return $album;
    }

}
