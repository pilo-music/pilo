<?php


namespace App\Http\Repositories\V1\Bookmark;


use App\Models\Bookmark;

class Has
{
    protected $client;
    protected $item;

    public function __construct()
    {
        $this->client = null;
        $this->item = null;
    }

    /**
     * @param null $client
     * @return Has
     */
    public function setClient($client): Has
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @param null $item
     * @return Has
     */
    public function setItem($item): Has
    {
        $this->item = $item;
        return $this;
    }


    public function build()
    {
        if ($this->client == null)
            return false;
        if ($this->item == null)
            return false;

        return Bookmark::query()->where('bookmarkable_id', $this->item->id)
            ->where('bookmarkable_type')->exists();
    }

}
