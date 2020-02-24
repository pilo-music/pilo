<?php

namespace Tests\Feature;

use App\Models\Album;

class AlbumsTest extends BaseTest
{
    public function testAlbums()
    {
        $response = $this->json('GET', '/api/v1/albums');
        $this->assertAll($response);
    }

    public function testAlbumsPage()
    {
        $response = $this->json('GET', '/api/v1/albums?page=2');
        $this->assertAll($response);
    }

    public function testAlbumsSort()
    {
        $response = $this->json('GET', '/api/v1/albums?sort=best');
        $this->assertAll($response);
    }

    public function testAlbumsCount()
    {
        $response = $this->json('GET', '/api/v1/albums?count=2');
        $this->assertAll($response);
    }

    public function testAlbumArtist()
    {
        $artist = Album::query()->latest()->first()->slug;
        $response = $this->json('GET', "/api/v1/albums?artist=$artist");
        $this->assertAll($response);
    }
}
