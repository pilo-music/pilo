<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Home;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $homes = Home::query()->where('status', Home::STATUS_ACTIVE)->get()->sortBy('row_number');

        $data = [];
        foreach ($homes as $item) {
            /*
             * get data from item type
             */
            $data[] = $this->getVitrineData($item, false, $item->count, 1);
        }

        return CustomResponse::create($data, '', true);
    }

    public function single()
    {
        /*
         * get params
         */
        $id = request()->id;
        $page = request()->has('page') ? request()->page : 1;
        $count = request()->has('count') ? request()->count : 12;

        if (!isset($id)) {
            return Response::create(false, 'Missing Params', \Illuminate\Http\Response::HTTP_BAD_REQUEST);
        }

        $vitrine = Vitrine::where('id', $id)->where('status', Vitrine::STATUS_ACTIVE)->first();
        if (!$vitrine) {
            return Response::create(false, 'not found', \Illuminate\Http\Response::HTTP_NOT_FOUND);
        }
        $return_info = $this->getVitrineData($vitrine, false, $count, $page);
        return Response::create(true, 'Vitrine', $return_info);
    }


    private function getVitrineData($item, $get_all, $count, $page)
    {
        switch ($item->type) {
            case Vitrine::TYPE_ARTISTS:
                $return_info = $this->getArtists($item, "artists", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_MUSICS:
                $return_info = $this->getMusics($item, "musics", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_ALBUMS:
                $return_info = $this->getAlbums($item, "albums", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_PLAYLISTS:
                $return_info = $this->getPlaylists($item, Playlist::TYPE_PLAYLIST, "playlists", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_CHARTS:
                $return_info = $this->getPlaylists($item, Playlist::TYPE_CHARTS, "charts", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_GENRES:
                $return_info = $this->getPlaylists($item, Playlist::TYPE_GENRES, "genres", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_HERO_SLIDERS:
                $return_info = $this->getHeroSliders($item, $get_all, $count, $page);
                break;
            case Vitrine::TYPE_AD:
                $return_info = $this->getAd($item);
                break;
            case Vitrine::TYPE_MUSIC_GRID:
                $return_info = $this->getGridMusics($item, "grid", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_PLAYLIST_GRID:
                $return_info = $this->getPlaylistGridMusics($item, Playlist::TYPE_PLAYLIST, "playlist_grid", $get_all, $count, $page);
                break;
            case Vitrine::TYPE_MUSIC_TRENDING:
                $return_info = $this->getTrendingMusics($item, "trending", $get_all, $count, $page);
                break;
            default:
                $return_info = [];
                break;
        }
        return $return_info;
    }


    private function getArtists($item, $type, $get_all, $count, $page)
    {
        $artists = [];
        if ($get_all || !isset($item->value) || $item->value == "" || $item->value == "-") {
            $artists = $this->artistRepo->get($item->sort, $count, $page, request()->region);
        } else {
            if ($page == 2) {
                return [];
            }
            $ids = explode('-', $item->value);
            foreach ($ids as $id) {
                if (isset($id)) {
                    $artist = $this->artistRepo->find(null, $id);
                    if ($artist)
                        $artists[] = $artist;
                }
            }
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $type,
            'data' => $this->artistRepo->toJsonArray($artists, request()->client_id)
        ];
    }


    private function getMusics($item, $type, $get_all, $count, $page)
    {
        $musics = [];
        if ($get_all || !isset($item->value) || $item->value == "" || $item->value == "-") {
            $musics = $this->musicRepo->get($item->sort, null, $count, $page, false, request()->region);
        } else {
            if ($page == 2) {
                return [];
            }
            $ids = explode('-', $item->value);
            foreach ($ids as $id) {
                if (isset($id)) {
                    $music = $this->musicRepo->find(null, $id);
                    if ($music)
                        $musics[] = $music;
                }
            }
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $type,
            'data' => $this->musicRepo->toJsonArray($musics)
        ];
    }


    private function getAlbums($item, $type, $get_all, $count, $page)
    {
        $albums = [];
        if ($get_all || !isset($item->value) || $item->value == "" || $item->value == "-") {
            $albums = $this->albumRepo->get($item->sort, null, $count, $page, request()->region);
        } else {
            if ($page == 2) {
                return [];
            }
            $ids = explode('-', $item->value);
            foreach ($ids as $id) {
                if (isset($id)) {
                    $album = $this->albumRepo->find(null, $id);
                    if ($album) {
                        $albums[] = $album;
                    }
                }
            }
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $type,
            'data' => $this->albumRepo->toJsonArray($albums)
        ];
    }


    private function getPlaylists($item, $type, $typeName, $get_all, $count, $page)
    {
        $playlists = [];
        if ($get_all || !isset($item->value) || $item->value == "" || $item->value == "-") {
            $playlists = $this->playlistRepo->get($type, $item->sort, $count, $page, null, request()->region);
        } else {
            if ($page == 2) {
                return [];
            }
            $ids = explode('-', $item->value);
            foreach ($ids as $id) {
                if (isset($id)) {
                    $playlist = $this->playlistRepo->find(null, $id, false, $type);
                    if ($playlist)
                        $playlists[] = $playlist;
                }
            }
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $typeName,
            'data' => $this->playlistRepo->toJsonArray($playlists)
        ];
    }


    private function getAd($item)
    {
        $heroSlider = $this->heroSliderRepo->find($item->value, HeroSlider::TYPE_AD);
        if ($heroSlider) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'type' => "ad",
                'data' => $this->heroSliderRepo->toJson($heroSlider)
            ];
        }
        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => "ad",
            'data' => []
        ];
    }

    private function getHeroSliders($item, $get_all, $count, $page)
    {
        $heroSliders = [];
        if ($get_all || !isset($item->value) || $item->value == "" || $item->value == "-") {
            $heroSliders = $this->heroSliderRepo->get(null, $count, $page);
        } else {
            if ($page == 2) {
                return [];
            }
            $ids = explode('-', $item->value);
            foreach ($ids as $id) {
                if (isset($id)) {
                    $heroSlider = $this->heroSliderRepo->find($id, null);
                    if (isset($heroSlider))
                        $heroSliders[] = $this->heroSliderRepo->toJson($heroSlider);
                }
            }
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => "hero_sliders",
            'data' => $heroSliders
        ];
    }

    /*
     * this func return last album and musics
     */
    private function getGridMusics($item, $type, $get_all, $count, $page)
    {
        if ($item->value != null || $item->value != "null" || $item != "-") {
            return $this->getMusics($item, "grid", $get_all, $count, $page);
        }


        if (!$get_all) {
            $limit = $item->count;
            if (isset(request()->region)) {
                $musics = Music::where('created_at', '>', now()->subDays(7))
                    ->where('status', Music::STATUS_ACTIVE)
                    ->where('region', request()->region)
                    ->latest()
                    ->take(7)->get();
            } else {
                $musics = Music::where('created_at', '>', now()->subDays(7))
                    ->where('status', Music::STATUS_ACTIVE)
                    ->latest()
                    ->take(7)->get();
            }

            if (isset(request()->region)) {
                $albums = Album::where('status', 1)
                    ->where('region', request()->region)
                    ->where('status', Album::STATUS_ACTIVE)
                    ->where('created_at', '>', now()->subDays(7))
                    ->latest()->get();
            } else {
                $albums = Album::where('status', 1)
                    ->where('status', Album::STATUS_ACTIVE)
                    ->where('created_at', '>', now()->subDays(7))
                    ->latest()->get();
            }
        } else {
            $limit = $count;
            $musics = $this->musicRepo->get(Music::TYPE_LATEST, null, $count, $page, true, request()->region);
            $albums = $this->albumRepo->get(Album::TYPE_LATEST, null, $count, $page, request()->region);
        }


        if (isset($albums) && count($albums) == 0)
            $albums = $this->albumRepo->getRandom(12);

        if (isset($musics) && count($musics) == 0)
            $musics = $this->musicRepo->getRandom(12);


        $musics_albums = $musics->merge($albums)->sortByDesc('created_at');


        $count = 0;
        $data = [];
        foreach ($musics_albums as $musics_album) {
            if ($count <= $limit) {
                if ($musics_album instanceof Album) {
                    $data[] = $this->albumRepo->toJson($musics_album);
                } else if ($musics_album instanceof Music) {
                    $data[] = $this->musicRepo->toJson($musics_album);
                }
            }
            $count++;
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $type,
            'data' => $data
        ];
    }

    private function getTrendingMusics($item, $type, $get_all, $count, $page)
    {
        if ($item->value != null || $item->value != "null" || $item != "-") {
            return $this->getMusics($item, "musics", $get_all, $count, $page);
        }

        if (!$get_all) {
            $musics = $this->musicRepo->get(Music::TYPE_BEST, null, $item->count, 1, true, request()->region);
            $albums = $this->albumRepo->get(Album::TYPE_BEST, null, $item->count, 1, request()->region);
        } else {
            $musics = $this->musicRepo->get(Music::TYPE_BEST, null, $count, $page, true, request()->region);
            $albums = $this->albumRepo->get(Album::TYPE_BEST, null, $count, $page, request()->region);
        }

        $musics_albums = $musics->merge($albums)->sortByDesc('play_count');

        $data = [];
        foreach ($musics_albums as $musics_album) {
            if ($musics_album instanceof Album) {
                $data[] = $this->albumRepo->toJson($musics_album);
            } else if ($musics_album instanceof Music) {
                $data[] = $this->musicRepo->toJson($musics_album);
            }
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $type,
            'data' => $data
        ];
    }

    private function getPlaylistGridMusics($item, $type, $typeName, $get_all, $count, $page)
    {
        $playlists = [];
        if ($get_all || !isset($item->value) || $item->value == "" || $item->value == "-") {
            $playlists = $this->playlistRepo->get($type, $item->sort, $count, $page, null, request()->region);
        } else {
            if ($page == 2) {
                return [];
            }
            $ids = explode('-', $item->value);
            foreach ($ids as $id) {
                if (isset($id)) {
                    $playlist = $this->playlistRepo->find(null, $id, false, $type);
                    if ($playlist)
                        $playlists[] = $playlist;
                }
            }
        }

        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $typeName,
            'data' => $this->playlistRepo->toJsonArray($playlists)
        ];
    }
}
