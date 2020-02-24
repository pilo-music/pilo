<?php

namespace Tests\Feature;

use App\Models\Music;

class MusicsTest extends BaseTest
{
    public function testMusics()
    {
        $response = $this->json('GET', '/api/v1/musics');
        $this->assertAll($response);
    }

    public function testMusicPage()
    {
        $response = $this->json('GET', '/api/v1/musics?page=2');
        $this->assertAll($response);
    }

    public function testMusicsSort()
    {
        $response = $this->json('GET', '/api/v1/musics?sort=best');
        $this->assertAll($response);
    }

    public function testMusicsCount()
    {
        $response = $this->json('GET', '/api/v1/musics?count=2');
        $this->assertAll($response);
    }

    public function testMusicArtist()
    {
        $artist = Music::query()->latest()->first()->slug;
        $response = $this->json('GET', "/api/v1/musics?artist=$artist");
        $this->assertAll($response);
    }
}
