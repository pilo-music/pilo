<?php

namespace Tests\Feature;

use App\Models\Artist;

class ArtistTest extends Base
{
    public function testArtist()
    {
        $item = Artist::query()->latest()->first()->slug;
        $response = $this->json('GET', "/api/v1/artist?slug=$item");
        $this->assertAll($response);
    }
}
