<?php

namespace Tests\Feature;

use App\Models\Music;

class MusicTest extends Base
{
    public function testMusic()
    {
        $music = Music::query()->where('status', 1)->latest()->first()->slug;
        $response = $this->json('GET', "/api/v1/music?slug=$music");
        $this->assertAll($response);
    }
}
