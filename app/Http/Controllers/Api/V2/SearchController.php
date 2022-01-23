<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\SearchClick;
use App\Models\SearchHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|max:50|min:1'
        ]);

        $page = $request->page ?? 1;
        $type = $request->type ?? null;
        $count = $request->has('count') ? $request->get('count') : 4;

        $history = SearchHistory::query()->create([
            'user_id' => $request->user('api') !== null ? $request->user("api")->id : null,
            'query' => $request->input('query'),
            'ip' => get_ip(),
            'agent' => $request->header('user-agent'),
        ]);


        $response = [
            'id' => $history->id,
            "musics" => [],
            "artists" => [],
            "albums" => [],
            'playlists' => []
        ];

        if ($type === "music") {
            $response['musics'] = $this->searchMusic($request->get('query'), $page, $count);
            return CustomResponse::create($response, "", true);
        }

        if ($type === "artist") {
            $response['artists'] = $this->searchArtist($request->get('query'), $page, $count);
            return CustomResponse::create($response, "", true);
        }

        if ($type === "album") {
            $response['albums'] = $this->searchAlbum($request->get('query'), $page, $count);
            return CustomResponse::create($response, "", true);
        }

        if ($type === "playlist") {
            $response['playlists'] = $this->searchPlaylist($request->get('query'), $page, $count);
            return CustomResponse::create($response, "", true);
        }


        $response['musics'] = $this->searchMusic($request->get('query'), $page, $count);
        $response['artists'] = $this->searchArtist($request->get('query'), $page, $count);
        $response['albums'] = $this->searchAlbum($request->get('query'), $page, $count);
        $response['playlists'] = $this->searchPlaylist($request->get('query'), $page, $count);

        return CustomResponse::create($response, "", true);
    }

    public function click(Request $request): JsonResponse
    {
        $request->validate([
            'id' => "required|exists:search_histories",
            'clickable_slug' => 'required',
            'clickable_type' => 'required|in:music,album,artist,playlist,video'
        ]);

        $item = match ($request->clickable_type) {
            "music" => MusicRepo::getInstance()->find()->setSlug($request->clickable_slug)->build(),
            "artist" => ArtistRepo::getInstance()->find()->setSlug($request->clickable_slug)->build(),
            "album" => AlbumRepo::getInstance()->find()->setSlug($request->clickable_slug)->build(),
            "playlist" => PlaylistRepo::getInstance()->find()->setSlug($request->clickable_slug)->build(),
            default => null,
        };

        if ($item) {
            SearchClick::query()->create([
                'search_history_id' => $request->id,
                'clickable_id' => $item->id,
                'clickable_type' => get_class($item),
            ]);

            $item->increment('search_count');
        }

        return CustomResponse::create(null, '', true);
    }


    private function searchMusic($q, $page, $count)
    {
        return MusicRepo::getInstance()->find()->setName($q)
            ->setSort(Music::SORT_SEARCH)
            ->setPage($page)
            ->setCount($count)->setToJson()->build();
    }

    private function searchArtist($q, $page, $count)
    {
        return ArtistRepo::getInstance()->find()->setName($q)
            ->setSort(Artist::SORT_SEARCH)
            ->setPage($page)
            ->setCount($count)->setToJson()->build();
    }

    private function searchAlbum($q, $page, $count)
    {
        return AlbumRepo::getInstance()->find()->setName($q)
            ->setSort(Album::SORT_SEARCH)
            ->setPage($page)
            ->setCount($count)->setToJson()->build();
    }

    private function searchPlaylist($q, $page, $count)
    {
        return PlaylistRepo::getInstance()->find()->setName($q)
            ->setSort(Playlist::SORT_SEARCH)
            ->setCount($count)
            ->setPage($page)
            ->setToJson()->build();
    }
}
