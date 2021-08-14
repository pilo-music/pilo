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
use App\Models\Browse;
use App\Models\Music;
use App\Models\PlayHistory;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    protected $page = 1;

    public function index()
    {
        $homes = Browse::query()->where('status', Browse::STATUS_ACTIVE)->get()->sortBy('row_number');

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
            'id' => 'required|exists:browses'
        ]);
        $this->page = $request->page ?? 1;
        /**
         * get params
         */
        $vitrine = Browse::query()->where('id', $request->id)->where('status', Browse::STATUS_ACTIVE)->firstOrFail();
        $data = $this->getVitrineData($vitrine);
        return CustomResponse::create($data, '', true);
    }


    private function getVitrineData($item)
    {
        switch ($item->type) {
            case Browse::TYPE_ARTISTS:
                $return_info = $this->getArtists($item, "artists");
                break;
            case Browse::TYPE_MUSICS:
                $return_info = $this->getMusics($item, "musics");
                break;
            case Browse::TYPE_ALBUMS:
                $return_info = $this->getAlbums($item, "albums");
                break;
            case Browse::TYPE_PLAYLISTS:
                $return_info = $this->getPlaylists($item, "playlists");
                break;
            case Browse::TYPE_PROMOTIONS:
                $return_info = $this->getPromotion($item, 'promotion');
                break;
            case Browse::TYPE_ALBUM_MUSIC_GRID:
                $return_info = $this->getGridAlbumMusics($item, "album_music_grid");
                break;
            case Browse::TYPE_MUSIC_GRID:
                $return_info = $this->getMusics($item, "music_grid");
                break;
            case Browse::TYPE_PLAYLIST_GRID:
                $return_info = $this->getPlaylists($item, "playlist_grid");
                break;
            case Browse::TYPE_MUSIC_TRENDING:
                $return_info = $this->getMusics($item, "trending");
                break;
            case Browse::TYPE_VIDEOS:
                $return_info = $this->getVideos($item, "videos");
                break;
            case Browse::TYPE_MUSIC_VERTICAL:
                $return_info = $this->getMusics($item, "music_vertical");
                break;
            case Browse::TYPE_FOR_YOU:
                $return_info = $this->getForYou($item, "for_you");
                break;
            case Browse::TYPE_PLAY_HISTORY:
                $return_info = $this->getStaticItem($item, "play_history");
                break;
            case Browse::TYPE_PLAY_FOLLOWS:
                $return_info = $this->getMusicFollows($item, "music_follows");
                break;
            case Browse::TYPE_BROWSE_DOCK:
                $return_info = $this->getStaticItem($item, "browse_dock");
                break;
            case Browse::TYPE_CLIENT_PLAYLISTS:
                $return_info = $this->getClientPlaylists($item, "playlists");
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
            $artists = ArtistRepo::getInstance()->get()->setCount($home->count)->setSort($home->sort)->setPage($this->page)->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $artist = ArtistRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($artist) {
                    $artists[] = $artist;
                }
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
            $musics = MusicRepo::getInstance()->get()->setSort($home->sort)->setCount($home->count)->setPage($this->page)->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $music = MusicRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($music) {
                    $musics[] = $music;
                }
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
            $albums = AlbumRepo::getInstance()->get()->setSort($home->sort)->setCount($home->count)->setPage($this->page)->setToJson()->build();
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
                ->setPage($this->page)
                ->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $playlist = PlaylistRepo::getInstance()->find()->setId($item)->setPage($this->page)->setToJson()->build();
                if ($playlist) {
                    $playlists[] = $playlist;
                }
            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $playlists
        ];
    }

    private function getPromotion($home, $type)
    {
        $promotions = [];
        if ($this->checkHomeValue($home)) {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $promotion = PromotionRepo::getInstance()->find()->setId($item)->setToJson();
                if ($promotion) {
                    $promotions[] = $promotion;
                }
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
                ->skip($this->page)
                ->take(7)->get();

            $albums = Album::query()->where('status', 1)
                ->where('status', Album::STATUS_ACTIVE)
                ->where('created_at', '>', now()->subDays(7))
                ->skip($this->page)
                ->latest()->get();
        } else {
            $limit = 18;
            $musics = MusicRepo::getInstance()->get()->setSort(Music::SORT_LATEST)
                ->setCount(9)->setPage($this->page)->build();
            $albums = AlbumRepo::getInstance()->get()->setSort(Album::SORT_LATEST)
                ->setCount(9)->setPage($this->page)->build();
        }


        if (isset($albums) && count($albums) == 0) {
            $albums = AlbumRepo::getInstance()->random()->setCount($limit - count($albums))->build();
        }

        if (isset($musics) && count($musics) == 0) {
            $musics = MusicRepo::getInstance()->random()->setCount($limit - count($musics))->build();
        }


        $musics_albums = $musics->merge($albums)->sortByDesc('created_at');


        $count = 0;
        $data = [];
        foreach ($musics_albums as $musics_album) {
            if ($count <= $limit) {
                if ($musics_album instanceof Album) {
                    $data[] = AlbumRepo::getInstance()->toJson()->setAlbum($musics_album)->build();
                } elseif ($musics_album instanceof Music) {
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
            $videos = VideoRepo::getInstance()->get()->setSort($home->sort)->setCount($home->count)->setPage($this->page)->setToJson()->build();
        } else {
            $items = $this->explodeHomeItems($home);
            foreach ($items as $item) {
                $video = VideoRepo::getInstance()->find()->setId($item)->setToJson()->build();
                if ($video) {
                    $videos[] = $video;
                }
            }
        }

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $videos
        ];
    }

    private function getForYou($item, $type)
    {
        if (auth()->guard('api')->check()) {
//            $user = request()->user('api');
//            $histories = PlayHistory::query()->where('user_id', $user->id)->where('historyable_type', Music::class)->limit(3)->get();
//            $data = [];
//            foreach ($histories as $history) {
//
//            }

            $data [] = [
                "title" => "آخرین موزیک ها",
                "image" => "",
                "music_count" => "",
                "musics" => MusicRepo::getInstance()->get()->setSort(Music::SORT_LATEST)->setCount(5)->setPage(1)->setToJson()->build(),
            ];

            $data [] = [
                "title" => "قدیمی ترین موزیک ها",
                "image" => "",
                "music_count" => "",
                "musics" => MusicRepo::getInstance()->get()->setSort(Music::SORT_OLDEST)->setCount(5)->setPage(1)->setToJson()->build(),
            ];

            $data [] = [
                "title" => "بهترین موزیک ها",
                "image" => "",
                "music_count" => "",
                "musics" => MusicRepo::getInstance()->get()->setSort(Music::SORT_BEST)->setCount(5)->setPage(1)->setToJson()->build(),
            ];
        }
        return [
            'id' => $item->id,
            'name' => $item->name,
            'type' => $type,
            'data' => []
        ];
    }


    private function getMusicFollows($item, $type)
    {
        return [];
    }

    private function getClientPlaylists($home, $type)
    {
        $data = PlaylistRepo::getInstance()->get()
            ->setUser(auth()->guard('api')->user())
            ->setSort($home->sort)
            ->setCount($home->count)
            ->setPage($this->page)
            ->setToJson()->build();

        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => $data
        ];
    }

    private function getStaticItem($home, $type)
    {
        return [
            'id' => $home->id,
            'name' => $home->name,
            'type' => $type,
            'data' => []
        ];
    }

    private function explodeHomeItems($item)
    {
        return $item->value != null ? explode('-', $item->value) : $item->value;
    }


    private function checkHomeValue($home): bool
    {
        return !(!isset($home->value) || $home->value == "" || $home->value == "-");
    }
}
