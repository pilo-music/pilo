<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Bookmark\BookmarkRepo;
use App\Http\Repositories\V1\Like\LikeRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Models\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{

    public function index()
    {
        /*
         * get params
         */
        $sort = request()->has('sort') ? request()->sort : Music::SORT_LATEST;
        $page = request()->has('page') ? request()->page : 1;
        $count = request()->has('count') ? request()->count : 12;
        $artist = request()->artist;

        $data = MusicRepo::getInstance()->get()->setPage($page)
            ->setCount($count)
            ->setArtist($artist)
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

        $music = MusicRepo::getInstance()->find()->setSlug($request->slug)->build();
        if (!$music) {
            abort(404);
        }

        return CustomResponse::create([
            'music' => MusicRepo::getInstance()->toJson()->setMusic($music)->build(),
            'related' => MusicRepo::getInstance()->get()->setArtist($music->artist)->setToJson()->build(),
            'has_like' => LikeRepo::getInstance()->has()->setClient($request->user())->setItem($music)->build(),
            'has_bookmark' => BookmarkRepo::getInstance()->has()->setClient($request->user())->setItem($music)->build(),
        ], '', true);
    }
}
