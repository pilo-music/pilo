<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Follow\FollowRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Http\Requests\Global\GetRequest;
use App\Http\Requests\Global\SingleRequest;
use App\Http\Resources\SimpleArtistResource;
use App\Models\Artist;
use App\Models\Music;

class ArtistController extends Controller
{
    public function index(GetRequest $request)
    {
        $order = $request->get('order_by', "created_at");
        $orderDirection = $request->get('order_direction', "desc");
        $page = $request->get('page', 1);
        $count = $request->get('count', Artist::DEFAULT_ITEM_COUNT);

        $items = Artist::query()
            ->select(["id", "name_en", "image"])
            ->active()
            ->orderBy($order, $orderDirection)
            ->simplePaginate(perPage: $count, page: $page);

        $data = SimpleArtistResource::collection($items);
        return response()->custom($data, '', true);
    }

    public function single(SingleRequest $request)
    {
        $item = Artist::query()->active()->findOrFail($request->get('id'));


        $bestMusics = MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_BEST)->setCount(5)->setWithTags(false)->setToJson()->build();
        if (count($bestMusics) == 0) {
            $bestMusics = MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_BEST)->setCount(5)->setWithTags(true)->setToJson()->build();
        }

        $lastMusics = MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_LATEST)->setCount(8)->setWithTags(false)->setToJson()->build();
        if (count($bestMusics) == 0) {
            $lastMusics = MusicRepo::getInstance()->get()->setArtist($artist)->setSort(Music::SORT_LATEST)->setCount(8)->setWithTags(true)->setToJson()->build();
        }

        /**
         * @todo add related artist
         */
        return CustomResponse::create([
            'artist' => ArtistRepo::getInstance()->toJson()->setArtist($artist)->build(),
            'is_follow' => FollowRepo::getInstance()->has()->setArtist($artist)->setUser($request->user())->build(),
            'best_musics' => $bestMusics,
            'last_musics' => $lastMusics,
            'playlists' => PlaylistRepo::getInstance()->get()->setArtist($artist)->setToJson()->build(),
            'albums' => AlbumRepo::getInstance()->get()->setArtist($artist)->setToJson()->build(),
            'videos' => VideoRepo::getInstance()->get()->setArtist($artist)->setToJson()->build(),
        ], '', true);
    }
}
