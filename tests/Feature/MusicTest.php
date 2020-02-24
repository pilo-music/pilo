<?php

namespace Tests\Feature;

use App\Models\Music;

class MusicTest extends BaseTest
{
    public function testMusic()
    {
        $album = Music::query()->latest()->first()->slug;
        $response = $this->json('GET', "/api/v1/music?slug=$album");
        $this->assertAll($response);
    }

}
