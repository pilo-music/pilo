<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AlbumResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "id" => $this->id,
            'title' => $this->title_en,
            'image' => get_image($this),
            'type' => 'album',
//            "share_url" => "https://pilo.app/share?id={$this->id}&type=album",
            'created_at' => Carbon::parse($this->created_at)->year,
            'artist' => new SimpleArtistResource($this->artist),
        ];
    }
}
