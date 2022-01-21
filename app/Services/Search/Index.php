<?php

namespace App\Services\Search;

use MeiliSearch\Client;

class Index
{
    public function __construct(private Client $client)
    {}

    public function add(array $item, $type): void
    {
        $this->client->index($type . "s")->addDocuments([$item]);
    }

    public function delete(array $item, $type): void
    {
        $this->client->index($type . "s")->deleteDocument($item['id']);
    }

    public function update(array $item, $type): void
    {
        $this->client->index($type . "s")->updateDocuments([$item]);
    }
}
