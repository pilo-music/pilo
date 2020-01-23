<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Libs\ViewAnalyse;
use App\Models\Album;
use App\Models\ViewAnalyse as Analyse;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    protected $albumRepo;

    public function __construct()
    {
        $this->albumRepo = AlbumRepo::getInstance();
    }

    public function single(Request $request)
    {
        // $request->validate([
        //     'slug' => 'required|exists:albums'
        // ]);
        // $hasLike = auth()->check() ? true : false;

        // /**
        //  * @var Album $album
        //  */
        // $album = $this->albumRepo->find()->setName($request->input('slug'))->build();
        // if (!$album) {
        //     // return abort(404);
        // }

        // ViewAnalyse::addView(Analyse::POST_TYPE_ALBUM, $album['id']);
        // $album->play_count = $album->play_count + 1;
        // $album->save();

        // return CustomResponse::create([
        //     'album' => $this->albumRepo->toJson($album),
        //     'musics' => $this->musicRepo->toJsonArray($this->albumRepo->musics($album)),
        //     'related' => $this->musicRepo->toJsonArray($related),
        //     'has_like' => LikeRepo::hasLike(request()->client_id, $album, 1),
        //     'has_dislike' => LikeRepo::hasLike(request()->client_id, $album, 0),
        // ], CustomResponse::SUCCESS);
    }

    public function get()
    {
    }
}
