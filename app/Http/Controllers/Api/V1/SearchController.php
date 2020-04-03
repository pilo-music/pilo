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

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|max:50|min:1'
        ]);

        $musics = MusicRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
        $artists = ArtistRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
        $videos = VideoRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
        $albums = AlbumRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();
        $playlist = PlaylistRepo::getInstance()->find()->setName($request->input('query'))->setToJson()->build();

        return CustomResponse::create([
            "musics" => $musics,
            "artists" => $artists,
            "videos" => $videos,
            "albums" => $albums,
            'playlist' => $playlist
        ], "", true);

    }

}
