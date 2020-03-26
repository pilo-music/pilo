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


    public function build(): array
    {
        if ($this->video) {
            return [
                'slug' => $this->music->slug,
                'name' => $this->music->title,
                'cover' => get_image($this->music, 'cover'),
                'thumbnail' => get_image($this->music, 'thumbnail'),
                'link128' => preg_replace("/ /", "%20", $music->link128 ?? ""),
                'link320' => preg_replace("/ /", "%20", $music->link320 ?? ""),
                'lyric' => $this->music->text ?? "",
                'like_count' => $this->music->like_count,
                'play_count' => $this->music->play_count,
                'created_at' => Carbon::parse($this->music->created_at)->format('D d,Y'),
                'type' => 'music',
                'tags' => ArtistRepo::getInstance()->toJsonArray()->setArtists($this->music->artists()->get())->build()
            ];
        }
        return null;
    }
}
