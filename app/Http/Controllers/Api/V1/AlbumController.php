<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Bookmark\BookmarkRepo;
use App\Http\Repositories\V1\Follow\FollowRepo;
use App\Http\Repositories\V1\Like\LikeRepo;
use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    public function index()
    {
        /*
         * get params
         */
        $sort = request()->has('sort') ? request()->sort : Album::SORT_LATEST;
        $page = request()->has('page') ? request()->page : 1;
        $count = request()->has('count') ? request()->count : Album::DEFAULT_ITEM_COUNT;
        $artist = request()->artist;

        $data = AlbumRepo::getInstance()->get()->setPage($page)
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
            'slug' => 'required|exists:albums,slug'
        ]);

        $album = AlbumRepo::getInstance()->find()->setSlug($request->slug)->build();
        if (!$album) {
            abort(404);
        }

        $related = AlbumRepo::getInstance()->get()->setArtist($album->artist)->build();
        if (count($related) < 12) {
            $dbRelated = AlbumRepo::getInstance()->random()->setCount(12 - count($related));
            $related = $related->merge($dbRelated);
        }
        return CustomResponse::create([
            'album' => AlbumRepo::getInstance()->toJson()->setAlbum($album)->build(),
            'musics' => AlbumRepo::getInstance()->musics()->setAlbum($album)->setToJson()->build(),
            'related' => AlbumRepo::getInstance()->toJsonArray()->setAlbums($related)->build(),
            'has_like' => LikeRepo::getInstance()->has()->setUser($request->user())->setItem($album)->build(),
            'has_bookmark' => BookmarkRepo::getInstance()->has()->setUser($request->user())->setItem($album)->build(),
        ], '', true);
    }
}
