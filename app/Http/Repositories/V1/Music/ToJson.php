<?php

namespace App\Http\Repositories\V1\Music;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use Carbon\Carbon;

class ToJson
{
    protected $music;

    public function __construct()
    {
        $this->music = null;
    }

    /**
     * @param null $music
     * @return ToJson
     */
    public function setMusic($music): ToJson
    {
        $this->music = $music;
        return $this;
    }


    public function build(): array
    {
        if ($this->music) {
            return [
                'slug' => $this->music->slug,
                'title' => $this->music->title,
                'image' => get_image($this->music, 'image'),
                'thumbnail' => get_image($this->music, 'thumbnail'),
                'link128' => preg_replace("/ /", "%20", $music->link128 ?? ""),
                'link320' => preg_replace("/ /", "%20", $music->link320 ?? ""),
                'lyric' => $this->music->text ?? "",
                'like_count' => $this->music->like_count,
                'play_count' => $this->music->play_count,
                'artist' => ArtistRepo::getInstance()->toJson()->setArtist($this->music->artist)->build(),
                'tags' => ArtistRepo::getInstance()->toJsonArray()->setArtists($this->music->artists()->get())->build(),
                'created_at' => Carbon::parse($this->music->created_at)->format('D d,Y'),
                'type' => 'music',

            ];
        }
        return null;
    }
}
