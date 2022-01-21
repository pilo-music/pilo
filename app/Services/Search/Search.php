<?php

namespace App\Services\Search;


use MeiliSearch\Client;

class Search
{
    public const INDEX_ARTIST = "artists";
    public const INDEX_MUSIC = "musics";
    public const INDEX_VIDEOS = "videos";
    public const INDEX_ALBUMS = "albums";
    public const INDEX_PLAYLIST = "playlists";

    private Client $client;

    public Index $index;

    public function __construct()
    {
        $host = config('pilo.meilisearch_host');
        $key = config('pilo.meilisearch_key');

        $this->client = new Client($host, $key);
        $this->index = new Index($this->client);
    }

    public function search($index, $text, $page = 1, $limit = 15)
    {
        $items = $this->client->index($index)->search($text, [
            "limit" => (int)$limit,
            "offset" => ($page - 1) * $limit
        ]);

        return $items;
    }
}
