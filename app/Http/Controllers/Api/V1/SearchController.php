<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\SearchClick;
use App\Models\SearchHistory;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|max:50|min:1'
        ]);

        $page = $request->page ?? 1;
        $type = $request->type ?? null;
        $count = $request->has('type') ? Music::DEFAULT_ITEM_COUNT : 4;

        if ($type) {
            switch ($type) {
                case "music":
                    $musics = MusicRepo::getInstance()->find()->setName($request->input('query'))
                        ->setPage($page)
                        ->setSort(Music::SORT_SEARCH)
                        ->setCount($count)
                        ->setToJson()->build();
                    $artists = [];
                    $videos = [];
                    $albums = [];
                    $playlist = [];
                    break;
                case "artist":
                    $artists = ArtistRepo::getInstance()->find()->setName($request->input('query'))
                        ->setPage($page)
                        ->setSort(Artist::SORT_SEARCH)
                        ->setCount($count)
                        ->setToJson()->build();
                    $musics = [];
                    $videos = [];
                    $albums = [];
                    $playlist = [];
                    break;
                case "video":
                    $videos = VideoRepo::getInstance()->find()->setName($request->input('query'))
                        ->setPage($page)
                        ->setSort(Video::SORT_SEARCH)
                        ->setCount($count)
                        ->setToJson()->build();
                    $albums = [];
                    $playlist = [];
                    $musics = [];
                    $artists = [];
                    break;
                case "album":
                    $albums = AlbumRepo::getInstance()->find()->setName($request->input('query'))
                        ->setPage($page)
                        ->setSort(Album::SORT_SEARCH)
                        ->setCount($count)
                        ->setToJson()->build();
                    $musics = [];
                    $artists = [];
                    $videos = [];
                    $playlist = [];
                    break;
                case "playlist":
                    $playlist = PlaylistRepo::getInstance()->find()->setName($request->input('query'))
                        ->setPage($page)
                        ->setSort(Playlist::SORT_SEARCH)
                        ->setCount($count)->setToJson()->build();
                    $musics = [];
                    $artists = [];
                    $videos = [];
                    $albums = [];
                    break;
                default:
                    $musics = [];
                    $artists = [];
                    $videos = [];
                    $albums = [];
                    $playlist = [];
            }
        } else {
            $musics = MusicRepo::getInstance()->find()->setName($request->input('query'))
                ->setSort(Music::SORT_SEARCH)
                ->setCount($count)->setToJson()->build();
            $artists = ArtistRepo::getInstance()->find()->setName($request->input('query'))
                ->setSort(Artist::SORT_SEARCH)
                ->setCount($count)->setToJson()->build();
//            $videos = VideoRepo::getInstance()->find()->setName($request->input('query'))
//                ->setSort(Video::SORT_SEARCH)
//                ->setCount($count)
//                ->setToJson()->build();
            $albums = AlbumRepo::getInstance()->find()->setName($request->input('query'))
                ->setSort(Album::SORT_SEARCH)
                ->setCount($count)->setToJson()->build();
            $playlist = PlaylistRepo::getInstance()->find()->setName($request->input('query'))
                ->setSort(Playlist::SORT_SEARCH)
                ->setCount($count)
                ->setToJson()->build();
        }

        $recommend = $this->getRecommend($request->input("query"));

        $history = SearchHistory::query()->create([
            'user_id' => $request->user('api') != null ? $request->user("api")->id : null,
            'query' => $request->input('query'),
            'current_spell' => $recommend,
            'ip' => get_ip(),
            'agent' => $request->header('user-agent'),
        ]);

        return CustomResponse::create([
            'id' => $history->id,
            "recommend" => $recommend,
            "musics" => $musics,
            "artists" => $artists,
            "videos" => [],
            "albums" => $albums,
            'playlists' => $playlist
        ], "", true);
    }

    private function getRecommend($q)
    {
//        m.parsijoo.ir/mobile-arbiter/MobileArbiter/webservlet?utm-source=cafebazaar&type=result&Version=1&nrpp=10&co=0&query=بهنام بانی
        try {
            $result = Http::get("https://www.googleapis.com/customsearch/v1?key=AIzaSyCx6JQt1pez7jr9euWMfJQU40QtTxdkjO0&cx=017576662512468239146:omuauf_lfve&q=" . $q);
            $result = json_decode($result->body());
            if (isset($result->spelling)){
                return ($result->spelling->correctedQuery);
            }
            return "";
        } catch (\Exception $e) {
            return "";
        }
    }

    public function click(Request $request)
    {
        $request->validate([
            'id' => "required|exists:search_histories",
            'clickable_slug' => 'required',
            'clickable_type' => 'required|in:music,album,artist,playlist,video'
        ]);

        switch ($request->clickable_type) {
            case "music":
                $item = MusicRepo::getInstance()->find()->setSlug($request->clickable_slug)->build();
                break;
            case "artist":
                $item = ArtistRepo::getInstance()->find()->setSlug($request->clickable_slug)->build();
                break;
            case "video":
//                $item = VideoRepo::getInstance()->find()->setSlug($request->clickable_slug)->build();
                $item = [];
                break;
            case "album":
                $item = AlbumRepo::getInstance()->find()->setSlug($request->clickable_slug)->build();
                break;
            case "playlist":
                $item = PlaylistRepo::getInstance()->find()->setSlug($request->clickable_slug)->build();
                break;
            default:
                $item = null;
                break;
        }
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
}
