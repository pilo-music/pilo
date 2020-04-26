<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Bookmark\BookmarkRepo;
use App\Http\Repositories\V1\Like\LikeRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{

    public function index()
    {
        /*
         * get params
         */
        $sort = request()->has('sort') ? request()->sort : Video::SORT_LATEST;
        $page = request()->has('page') ? request()->page : 1;
        $count = request()->has('count') ? request()->count : Video::DEFAULT_ITEM_COUNT;
        $artist = request()->artist;

        $data = VideoRepo::getInstance()->get()->setPage($page)
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

        $video = VideoRepo::getInstance()->find()->setSlug($request->slug)->build();
        if (!$video) {
            abort(404);
        }

        /**
         * @todo make better related music
         */
        return CustomResponse::create([
            'video' => VideoRepo::getInstance()->toJson()->setVideo($video)->build(),
            'related' => VideoRepo::getInstance()->get()->setArtist($video->artist)->setToJson()->build(),
            'has_like' => LikeRepo::getInstance()->has()->setUser($request->user("api"))->setItem($video)->build(),
            'has_bookmark' => BookmarkRepo::getInstance()->has()->setUser($request->user("api"))->setItem($video)->build(),
        ], '', true);
    }
}
