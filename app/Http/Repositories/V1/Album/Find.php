<?php


namespace App\Http\Repositories\V1\Album;


use App\Models\Album;
use App\Models\Artist;

class Find
{
    protected $count;
    protected $page;
    protected $sort;
    protected $name;
    protected $slug;
    protected $artist;

    public function __construct()
    {
        $this->count = Album::DEFAULT_ITEM_COUNT;
        $this->page = 1;
        $this->sort = Album::SORT_LATEST;
        $this->name = null;
        $this->slug = null;
        $this->artist = null;
    }

    /**
     * @param int $count
     * @return Find
     */
    public function count(int $count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function page(int $page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param int $sort
     * @return Find
     */
    public function sort(int $sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @param string $name
     * @return Find
     */
    public function name($name)
    {
        $this->name = strval($name);
        return $this;
    }

    /**
     * @param string $slug
     * @return Find
     */
    public function slug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param $artist
     * @return Find
     */
    public function artist($artist)
    {
        $this->artist = $artist;
        return $this;
    }

    /**
     * @return array|null|Album
     */
    public function build()
    {
        if (!$this->artist instanceof Artist)
            $this->artist = Artist::find($this->artist);

        if (isset($this->name) && !empty($this->name)) {
            /*
             *  find from name
             */
            $albums = Album::where('name', 'LIKE', '%' . $this->name . '%')
                ->where('status', Album::STATUS_ACTIVE);

            if (isset($this->artist)) {
                $albums = $albums->where('artist_id', $this->artist->id);

                $tagAlbums = $this->artist->tagAlbums()->get();

                if (count($tagAlbums) > 0) {
                    $albums = $albums->merge($tagAlbums);
                }
            }

            switch ($this->sort) {
                case Album::SORT_LATEST:
                    $albums = $albums->latest();
                    break;
                case  Album::SORT_BEST:
                    return $albums->skip(($this->page - 1) * $this->count)->take($this->count)->get()->sortBy('play_count');
                    break;
            }

            $albums = $albums->skip(($this->page - 1) * $this->count)->take($this->count)->get();

            return $albums;
        } else {
            /*
             * find from slug
             */
            if (isset($this->slug) && $this->slug != "") {
                return Album::where('status', Album::STATUS_ACTIVE)
                    ->where('slug', $this->slug)->first();
            }
        }
        return null;
    }
}
