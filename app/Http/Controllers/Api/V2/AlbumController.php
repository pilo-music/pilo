<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Like\LikeRepo;
use App\Http\Requests\Global\GetRequest;
use App\Http\Requests\Global\SingleRequest;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\MusicResource;
use App\Models\Album;
use App\Models\Music;
use Illuminate\Http\JsonResponse;

class AlbumController extends Controller
{
    public function index(GetRequest $request): JsonResponse
    {
        $order = $request->get('order_by', "created_at");
        $orderDirection = $request->get('order_direction', "desc");
        $page = $request->get('page', 1);
        $count = $request->get('count', Album::DEFAULT_ITEM_COUNT);
        $artist = $request->get('artist_id');

        $items = Album::query()
            ->select(["id", "title_en", "image", "created_at", "artist_id"])
            ->active()
            ->with('artist');

        if ($artist) $items = $items->where('artist_id', $artist);
        $items = $items->orderBy($order, $orderDirection);
        $items = $items->simplePaginate(perPage: $count, page: $page);

        $data = AlbumResource::collection($items);
        return response()->custom($data, '', true);
    }

    public function single(SingleRequest $request): JsonResponse
    {
        $album = Album::query()->active()->with('artist:id,name_en,image')->findOrFail($request->get('id'));
        $musics = Music::query()->where('album_id', $album->id)->get();
        $related = Album::query()->active()->with('artist:id,name_en,image')->where('artist_id', $album->artist_id)->limit(10)->latest()->get();

        return response()->custom([
            'album' => new AlbumResource($album),
            'musics' => MusicResource::collection($musics),
            'related' => AlbumResource::collection($related),
            'has_like' => LikeRepo::getInstance()->has()->setUser($request->user("api"))->setItem($album)->build(),
        ], '', true);
    }
}
