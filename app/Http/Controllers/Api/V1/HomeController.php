<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Promotion\PromotionRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Models\Album;
use App\Models\Home;
use App\Models\Music;
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
            $data[] = $this->getVitrineData($item);
        }

        return CustomResponse::create($data, '', true);
    }

    public function single(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:homes'
        ]);
        /**
         * get params
         */
        $vitrine = Home::query()->where('id', $request->id)->where('status', Home::STATUS_ACTIVE)->firstOrFail();
        $data = $this->getVitrineData($vitrine);
        return CustomResponse::create($data, '', true);
    }


    private function getVitrineData($item)
    {
        switch ($item->type) {
            case Home::TYPE_ARTISTS:
                $return_info = $this->getArtists($item, "artists");
                break;
            case Home::TYPE_MUSICS:
                $return_info = $this->getMusics($item, "musics");
                break;
            case Home::TYPE_ALBUMS:
                $return_info = $this->getAlbums($item, "albums");
                break;
            case Home::TYPE_PLAYLISTS:
                $return_info = $this->getPlaylists($item, "playlists");
                break;
            case Home::TYPE_PROMOTIONS:
                $return_info = $this->getPromotion($item, 'promotion');
                break;
            case Home::TYPE_ALBUM_MUSIC_GRID:
                $return_info = $this->getGridAlbumMusics($item, "album_music_grid");
                break;
            case Home::TYPE_MUSIC_GRID:
                $return_info = $this->getMusics($item, "music_grid");
                break;
            case Home::TYPE_PLAYLIST_GRID:
                $return_info = $this->getPlaylists($item, "playlist_grid");
                break;
            case Home::TYPE_MUSIC_TRENDING:
                $return_info = $this->getMusics($item, "trending");
                break;
            case Home::TYPE_VIDEOS:
                $return_info = $this->getVideos($item, "videos");
                break;
            default:
                $return_info = [];
                break;
        }
        return $return_info;
    }


    private function getArtists($home, $type)
    {
        $artists = [];
        if (!$this->checkHomeValue($home)) {
            $artists = ArtistRepo::getInstance()->get()->setCount($home->count)->setSort($home->sort)->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $artist = ArtistRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($artist)
                    $artists[] = $artist;
            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $artists
        ];
    }


    private function getMusics($home, $type)
    {
        $musics = [];
        if (!$this->checkHomeValue($home)) {
            $musics = MusicRepo::getInstance()->get()->setSort($home->sort)->setCount($home->count)->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $music = MusicRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($music)
                    $musics[] = $music;
            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $musics
        ];
    }


    private function getAlbums($home, $type)
    {
        $albums = [];
        if (!$this->checkHomeValue($home)) {
            $albums = AlbumRepo::getInstance()->get()->setSort($home->sort)->setCount($home->count)->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $album = AlbumRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($album) {
                    $albums[] = $album;
                }
            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $albums
        ];
    }


    private function getPlaylists($home, $type)
    {
        $playlists = [];
        if (!$this->checkHomeValue($home)) {
            $playlists = PlaylistRepo::getInstance()->get()->setSort($home->sort)
                ->setCount($home->count)
                ->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $playlist = PlaylistRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($playlist)
                    $playlists[] = $playlist;
            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'items' => $playlists
        ];
    }

    private function getPromotion($home, $type)
    {
        $promotions = [];
        if ($this->checkHomeValue($home)) {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $promotion = PromotionRepo::getInstance()->find()->setId($item)->setToJson();
                if ($promotion)
                    $promotions[] = $promotion;

            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $promotions
        ];
    }

    /*
     * this func return last album and musics
     */
    private function getGridAlbumMusics($home, $type)
    {
        if (!$this->checkHomeValue($home)) {
            $limit = $home->count;
            $musics = Music::query()->where('created_at', '>', now()->subDays(7))
                ->where('status', Music::STATUS_ACTIVE)
                ->latest()
                ->take(7)->get();

            $albums = Album::query()->where('status', 1)
                ->where('status', Album::STATUS_ACTIVE)
                ->where('created_at', '>', now()->subDays(7))
                ->latest()->get();

        } else {
            $limit = 18;
            $musics = MusicRepo::getInstance()->get()->setSort(Music::SORT_LATEST)
                ->setCount(9)->build();
            $albums = AlbumRepo::getInstance()->get()->setSort(Album::SORT_LATEST)
                ->setCount(9)->build();
        }


        if (isset($albums) && count($albums) == 0)
            $albums = AlbumRepo::getInstance()->random()->setCount($limit - count($albums))->build();

        if (isset($musics) && count($musics) == 0)
            $musics = MusicRepo::getInstance()->random()->setCount($limit - count($musics))->build();


        $musics_albums = $musics->merge($albums)->sortByDesc('created_at');


        $count = 0;
        $data = [];
        foreach ($musics_albums as $musics_album) {
            if ($count <= $limit) {
                if ($musics_album instanceof Album) {
                    $data[] = AlbumRepo::getInstance()->toJson()->setAlbum($musics_album)->build();
                } else if ($musics_album instanceof Music) {
                    $data[] = MusicRepo::getInstance()->toJson()->setMusic($musics_album)->build();
                }
            }
            $count++;
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $data
        ];
    }

    private function getVideos($home, $type)
    {
        $videos = [];
        if (!$this->checkHomeValue($home)) {
            $videos = VideoRepo::getInstance()->get()->setSort($home->sort)->setCount($home->count)->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $video = VideoRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($video)
                    $videos[] = $video;
            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $videos
        ];
    }

    private function explodeHomeItems($item)
    {
        return $item->value != null ? explode('-', $item->value) : $item->value;
    }


    private function checkHomeValue($home)
    {
        if (!isset($home->value) || $home->value == "" || $home->value == "-") {
            return false;
        }
        return true;
    }
}
