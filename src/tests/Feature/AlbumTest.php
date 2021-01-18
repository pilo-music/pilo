<?php

namespace Tests\Feature;

use App\Models\Album;

class AlbumTest extends Base
{
    public function testAlbum()
    {
        $album = Album::query()->latest()->first()->slug;
        $response = $this->json('GET', "/api/v1/album?slug=$album");
        $this->assertAll($response);
    }

}
