<?php

namespace App\Http\Repositories\V1\Promotion;

use App\Models\Promotion;

class ToJson
{
    protected $promotion;

    public function __construct()
    {
        $this->promotion = null;
    }

    /**
     * Set the value of promotion
     *
     * @param $promotion
     * @return  self
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;

        return $this;
    }

    public function build()
    {
        if ($this->promotion) {
            return [
                "title" => $this->promotion->title ?? "",
                "title_en" => $this->promotion->title_en ?? "",
                "image" => get_image($this->promotion),
                "slug" => $this->promotion->slug,
                "type" => $this->getType($this->promotion->type),
                "url" => $this->promotion->url ?? "",
            ];
        }
        return  null;
    }


    private function getType($type)
    {
        switch ($type) {
            case Promotion::TYPE_MUSIC:
                return "music";
                break;
            case Promotion::TYPE_ALBUM:
                return "album";
                break;
            case Promotion::TYPE_ARTIST:
                return "artist";
                break;
            case Promotion::TYPE_VIDEO:
                return "video";
                break;
            case Promotion::TYPE_PLAYLIST:
                return "playlist";
                break;
            default:
                return "ad";
                break;
        }
    }
}
