<?php


namespace App\Http\Repositories\V1\User;


class ToJson
{
    protected $user;

    public function __construct()
    {
        $this->user = null;
    }

    /**
     * Set the value of user
     *
     * @param $user
     * @return  self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    public function build(): array
    {
        if ($this->user) {
            return [
                "name" => $this->user->name ?? "",
                "email" => $this->user->email ?? "",
                "phone" => $this->user->phone ?? "",
                "birth" => $this->user->birth ?? "",
                "gender" => $this->user->gender ?? "",
                "pic" => get_image($this->user,'pic') ?? "",
            ];
        }
    }
}
