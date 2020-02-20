<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Response;
use App\Libs\ViewAnalyse;
use App\Models\Album;
use App\Models\ViewAnalyse as Analyse;
use Illuminate\Http\Request;

class AlbumController extends Controller
{

    public function index()
    {
        /*
         * get params
         */
        $sort = request()->has('sort') ? request()->type : Album::SORT_LATEST;
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
            'slug' => 'required|exists:albums'
        ]);

        $album = AlbumRepo::getInstance()->find()->setSlug($request->slug)->setToJson()->build();
        if (!$album) {
            abort(404);
        }

        $artists = $album->artists()->get();
        $related = $this->musicRepo->get(Music::TYPE_LATEST, $artists[0], 12, 1, false);
        if ($related == null)
            $related = [];

        return CustomResponse::create([
            'album' => $album,
            'categories' => $this->albumRepo->categories($album),
            'musics' => $this->musicRepo->toJsonArray($this->albumRepo->musics($album)),
            'related' => $this->musicRepo->toJsonArray($related),
            'has_like' => LikeRepo::hasLike(request()->client_id, $album, 1),
            'has_dislike' => LikeRepo::hasLike(request()->client_id, $album, 0),
        ], '', true);
    }
}
