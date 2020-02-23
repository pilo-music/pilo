<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Bookmark\BookmarkRepo;
use App\Http\Repositories\V1\Like\LikeRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
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
        $count = request()->has('count') ? request()->count : 12;

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
            'slug' => 'required|exists:musics,slug'
        ]);

        $artist = ArtistRepo::getInstance()->find()->setSlug($request->slug)->build();
        if (!$artist) {
            abort(404);
        }

        return Response::create(true, 'Artist find', [
            'artist' => ArtistRepo::getInstance()->toJson()->setArtist($artist)->build(),
            'top_songs' => MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_BEST)->setToJson()->build(),
            'last_songs' => MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_LATEST)->setToJson()->build(),
            'playlists' => $playlists,
            'appears_on' => $appearsOn,
            'related_artist' => $this->artistRepo->toJsonArray($related_artists),
            'albums' => $this->albumRepo->toJsonArray($albums),
        ]);

        return CustomResponse::create([
            'music' => ArtistRepo::getInstance()->toJson()->setMusic($music)->build(),
            'related' => ArtistRepo::getInstance()->get()->setArtist($music->artist)->setToJson()->build(),
            'has_like' => LikeRepo::getInstance()->has()->setClient($request->user())->setItem($artist)->build(),
            'has_bookmark' => BookmarkRepo::getInstance()->has()->setClient($request->user())->setItem($artist)->build(),
        ], '', true);
    }
}
