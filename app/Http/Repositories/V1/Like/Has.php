<?php


namespace App\Http\Repositories\V1\Like;


use App\Models\Like;

class Has
{
    protected $user;
    protected $item;

    public function __construct()
    {
        $this->user = null;
        $this->item = null;
    }

    /**
     * @param null $user
     * @return Has
     */
    public function setUser($user): Has
    {
        $this->user = $user;
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
        if ($this->user == null)
            return false;
        if ($this->item == null)
            return false;

        return Like::query()->where('likeable_id', $this->item->id)
            ->where('likeable_type')
            ->where('user_id', $this->user->id)->exists();
    }

}
