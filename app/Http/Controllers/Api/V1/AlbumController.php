<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Bookmark\BookmarkRepo;
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
        $count = request()->has('count') ? request()->count : 12;
        $artist = request()->artist;

        $data = AlbumRepo::getInstance()->get()->setPage($page)
            ->setCount($count)
            ->setArtist($artist)
            ->setSort($sort)
            ->setToJson()
            ->build();

        if (!$data) {
            abort(404);
        }

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
        $related = AlbumRepo::getInstance()->get()->setArtist($album->artist)->setToJson()->build();
        if (count($related) < 12) {
            $related = $related->merge(AlbumRepo::getInstance()->random()->setCount(12 - count($related))->build());
        }


        return CustomResponse::create([
            'album' => AlbumRepo::getInstance()->toJson()->setAlbum($album)->build(),
            'musics' => AlbumRepo::getInstance()->musics()->setAlbum($album->artist)->setToJson()->build(),
            'related' => $related,
            'has_like' => LikeRepo::getInstance()->has()->setClient($request->user())->setItem($album)->build(),
            'has_bookmark' => BookmarkRepo::getInstance()->has()->setClient($request->user())->setItem($album)->build(),
        ], '', true);
    }
}
