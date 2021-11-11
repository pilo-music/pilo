<?php

namespace App\Http\Repositories\V1\Video;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use Carbon\Carbon;

class ToJson
{
    protected $video;

    public function __construct()
    {
        $this->video = null;
    }

    /**
     * @param null $video
     * @return ToJson
     */
    public function setVideo($video): ToJson
    {
        $this->video = $video;
        return $this;
    }


    public function build()
    {
        if ($this->video) {
            $slug = $this->video->slug;
            return [
                'slug' => $slug,
                'title' => $this->video->title_en,
                'image' => get_image($this->video, 'image'),
                'thumbnail' => get_image($this->video, 'thumbnail'),
                'video480' => preg_replace("/ /", "%20", $this->video->video480 ?? ""),
                'video720' => preg_replace("/ /", "%20", $this->video->video720 ?? ""),
                'video1080' => preg_replace("/ /", "%20", $this->video->video1080 ?? ""),
                'like_count' => $this->video->like_count,
                'play_count' => $this->video->play_count,
                'artist' => ArtistRepo::getInstance()->toJson()->setArtist($this->video->artist)->build(),
                "share_url" => "https://pilo.app/share?slug={$slug}type=video",
                'created_at' => Carbon::parse($this->video->created_at)->format('D d,Y'),
                'type' => 'video',
                'tags' => ArtistRepo::getInstance()->toJsonArray()->setArtists($this->video->artists()->get())->build()
            ];
        }
        return null;
    }
}
