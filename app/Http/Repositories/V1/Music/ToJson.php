<?php

namespace App\Http\Repositories\V1\Music;

use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Like\LikeRepo;
use App\Models\Music;
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
        if (is_array($music)) {
            $this->music = Music::query()->where('slug', $music['slug'])->first();
        } else {
            $this->music = $music;
        }

        return $this;
    }


    public function build()
    {
        if ($this->music) {
            return [
                'slug' => $this->music->slug,
                'title' => $this->music->title_en,
                'image' => get_image($this->music, 'image'),
                'thumbnail' => get_image($this->music, 'thumbnail'),
                'link128' => preg_replace("/ /", "%20", $this->music->link128 ?? ""),
                'link320' => preg_replace("/ /", "%20", $this->music->link320 ?? ""),
                'lyric' => $this->music->text ?? "",
                'like_count' => $this->music->like_count,
                'play_count' => $this->music->play_count,
                'artist' => ArtistRepo::getInstance()->toJson()->setArtist($this->music->artist)->build(),
                'tags' => ArtistRepo::getInstance()->toJsonArray()->setArtists($this->music->artists()->get())->build(),
                "share_url" => "https://pilo.app/music/" . $this->music->slug,
                'created_at' => Carbon::parse($this->music->created_at)->format('D d,Y'),
                'type' => 'music',
                'has_like' => LikeRepo::getInstance()->has()->setUser(request()->user("api"))->setItem($this->music)->build(),
            ];
        }
        return null;
    }
}
