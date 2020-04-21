<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|max:50|min:1'
        ]);

        $page = $request->page ?? 1;
        $type = $request->type ?? null;

        if ($type) {
            switch ($type) {
                case "music":
                    $musics = MusicRepo::getInstance()->find()->setName($request->input('query'))->setPage($page)->setToJson()->build();
                    $artists = [];
                    $videos = [];
                    $albums = [];
                    $playlist = [];
                    break;
                case "artist":
                    $artists = ArtistRepo::getInstance()->find()->setName($request->input('query'))->setPage($page)->setToJson()->build();
                    $musics = [];
                    $videos = [];
                    $albums = [];
                    $playlist = [];
                    break;
                case "video":
                    $videos = VideoRepo::getInstance()->find()->setName($request->input('query'))->setPage($page)->setToJson()->build();
                    $albums = [];
                    $playlist = [];
                    $musics = [];
                    $artists = [];
                    break;
                case "album":
                    $albums = AlbumRepo::getInstance()->find()->setName($request->input('query'))->setPage($page)->setToJson()->build();
                    $musics = [];
                    $artists = [];
                    $videos = [];
                    $playlist = [];
                    break;
                case "playlist":
                    $playlist = PlaylistRepo::getInstance()->find()->setName($request->input('query'))->setPage($page)->setToJson()->build();
                    $musics = [];
                    $artists = [];
                    $videos = [];
                    $albums = [];
                    break;
                default:
                    $musics = [];
                    $artists = [];
                    $videos = [];
                    $albums = [];
                    $playlist = [];
            }
        } else {
            $musics = MusicRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
            $artists = ArtistRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
            $videos = VideoRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
            $albums = AlbumRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
            $playlist = PlaylistRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
        }

        return CustomResponse::create([
            "recommend" => $this->getRecommend($request->input("query")),
            "musics" => $musics,
            "artists" => $artists,
            "videos" => $videos,
            "albums" => $albums,
            'playlists' => $playlist
        ], "", true);

    }

    private function getRecommend($q)
    {
//        try {
            $result = Http::get("https://www.googleapis.com/customsearch/v1?key=AIzaSyCx6JQt1pez7jr9euWMfJQU40QtTxdkjO0&cx=017576662512468239146:omuauf_lfve&q=" . $q);
            $result = json_decode($result->body());
            return ($result->spelling->correctedQuery);
//        } catch (\Exception $e) {
//            return "";
//        }
    }

}
