<?php

namespace Tests\Feature;

class ArtistsTest extends BaseTest
{
    public function testArtists()
    {
        $response = $this->json('GET', '/api/v1/artists');
        $this->assertAll($response);
    }

    public function testArtistsPage()
    {
        $response = $this->json('GET', '/api/v1/artists?page=2');
        $this->assertAll($response);
    }

    public function testArtistsSort()
    {
        $response = $this->json('GET', '/api/v1/artists?sort=best');
        $this->assertAll($response);
    }

    public function testArtistsCount()
    {
        $response = $this->json('GET', '/api/v1/artists?count=2');
        $this->assertAll($response);
    }
}
