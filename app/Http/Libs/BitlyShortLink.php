<?php

namespace App\Libs;

use Illuminate\Support\Facades\Http;

class BitlyShortLink
{
    public static function generate($link)
    {
        $response = Http::get('https://api-ssl.bitly.com/v3/shorten',[
            'longUrl' => $link,
            'access_token' => '52c62a83d32ffbbe03e8d13a661b8d114fcdb763',
        ]);

        if ($response->status() == 200) {
            $body = $response->body();
            $arr_body = json_decode($body);
            return $arr_body->data->url;
        }
    }
}
