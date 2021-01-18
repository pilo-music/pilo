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

    public function build()
    {
        if ($this->user) {
            return [
                'name' => $this->user->name ?? "",
                'email' => $this->user->email ?? "",
                'phone' => $this->user->phone ?? "",
                'birth' => $this->user->birth ?? "",
                'gender' => $this->user->gender ?? "",
                'pic' => get_image($this->user,'pic') ?? "",
                'global_notification' => $this->user->global_notification,
                'music_notification' => $this->user->music_notification,
                'album_notification' => $this->user->album_notification,
                'video_notification' => $this->user->video_notification,
            ];
        }
        return  null;
    }
}
