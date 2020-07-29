<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Follow\FollowRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Models\Artist;
use App\Models\Music;
use Illuminate\Http\Request;

class ArtistController extends Controller
{

    public function index()
    {
        /*
         * get params
         */
        $sort = request()->has('sort') ? request()->sort : Artist::SORT_LATEST;
        $page = request()->has('page') ? request()->page : 1;
        $count = request()->has('count') ? request()->count : Artist::DEFAULT_ITEM_COUNT;

        $data = ArtistRepo::getInstance()->get()->setPage($page)
            ->setCount($count)
            ->setSort($sort)
            ->setToJson()
            ->build();

        return CustomResponse::create($data, '', true);
    }

    public function single(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:artists,slug'
        ]);

        $artist = ArtistRepo::getInstance()->find()->setSlug($request->slug)->build();

        if (!$artist) {
            abort(404);
        }

        /**
         * @todo add related artist
         */
        return CustomResponse::create([
            'artist' => ArtistRepo::getInstance()->toJson()->setArtist($artist)->build(),
            'is_follow' => FollowRepo::getInstance()->has()->setArtist($artist)->setUser($request->user())->build(),
            'best_musics' => MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_BEST)->setCount(5)->setWithTags(true)->setToJson()->build(),
            'last_musics' => MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_LATEST)->setCount(8)->setWithTags(true)->setToJson()->build(),
            'playlists' => PlaylistRepo::getInstance()->get()->setArtist($artist)->setToJson()->build(),
            'albums' => AlbumRepo::getInstance()->get()->setArtist($artist)->setToJson()->build(),
            'videos' => VideoRepo::getInstance()->get()->setArtist($artist)->setToJson()->build(),
        ], '', true);
    }
}
