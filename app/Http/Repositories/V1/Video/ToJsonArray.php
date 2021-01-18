<?php

namespace App\Http\Repositories\V1\Video;

class ToJsonArray
{
    protected $videos;

    public function __construct()
    {
        $this->videos = null;
    }

    /**
     *
     * @param $videos
     * @return  self
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;

        return $this;
    }


    public function build()
    {
        return $this->videos->map(function ($item) {
            return VideoRepo::getInstance()->toJson()->setVideo($item)->build();
        });
    }
}
