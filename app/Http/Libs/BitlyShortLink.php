<?php

namespace App\Libs;

use GuzzleHttp\Client;

class BitlyShortLink
{
    public static function generate($link)
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://api-ssl.bitly.com/',
        ]);

        $response = $client->request('GET', 'v3/shorten', [
            'query' => [
                'longUrl' => $link,
                'access_token' => '52c62a83d32ffbbe03e8d13a661b8d114fcdb763',
            ],
            'verify' => false,
        ]);

        if ($response->getStatusCode() == 200) {
            $body = $response->getBody();
            $arr_body = json_decode($body);
            return $arr_body->data->url;
        }
    }
}