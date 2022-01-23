<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleArtistResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            'name' => $this->name_en,
            'image' => get_image($this),
        ];
    }
}
