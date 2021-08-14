<?php

namespace App\Http\Repositories\V1\User;

use Illuminate\Support\Collection;

class ToJsonArray
{
    protected $users;

    public function __construct()
    {
        $this->users = collect([]);
    }

    /**
     * Set the value of playlists
     *
     * @param Collection $users
     * @return  self
     */
    public function setUsers(Collection $users)
    {
        $this->users = $users;

        return $this;
    }

    public function build()
    {
        return $this->users->map(function ($item) {
            return UserRepo::getInstance()->toJson()->setUser($item)->build();
        });
    }
}
