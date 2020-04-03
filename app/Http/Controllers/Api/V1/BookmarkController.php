<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class BookmarkController extends Controller
{
    public function bookmark(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'type' => 'required|in:music,album,playlist,video',
            'action' => 'required|in:add,remove',
        ]);

        $user = auth()->user();
        $item = $this->getBookmarkItem($request->slug, $request->type);

        if (!$item['item']) {
            abort(404);
        }

        $bookmark = $user->bookmarks()->where('bookmarkable_id', $item['item']->id)
            ->where('bookmarkable_type', get_class($item['item']))
            ->first();

        if ($request->action == "add" && !$bookmark) {
            $user->bookmarks()->create([
                'bookmarkable_id' => $item['item']->id,
                "bookmarkable_type" => get_class($item['item'])
            ]);
        } elseif ($request->action == "remove" && $bookmark) {
            $bookmark->delete();
        }
        return CustomResponse::create($item['json'], "", true);
    }

    public function index()
    {
        $user = auth()->user();
        $bookmarks = $user->bookmarks()->latest()->get();

        $return_info = [];
        foreach ($bookmarks as $bookmark) {
            if ($bookmark->bookmarkable_type == get_class(new Music())) {
                $item = MusicRepo::getInstance()->find()->setId($bookmark->bookmarkable_id)->setToJson()->build();
            } else if ($bookmark->bookmarkable_type == get_class(new Video())) {
                $item = VideoRepo::getInstance()->find()->setId($bookmark->bookmarkable_id)->setToJson()->build();
            } elseif ($bookmark->bookmarkable_type == get_class(new Playlist())) {
                $item = PlaylistRepo::getInstance()->find()->setId($bookmark->bookmarkable_id)->setToJson()->build();
            } else {
                $item = AlbumRepo::getInstance()->find()->setId($bookmark->bookmarkable_id)->setToJson()->build();
            }
            if (!$item) {
                continue;
            }
            $return_info[] = $item;
        }
        return CustomResponse::create($return_info, '', true);
    }


    private function getBookmarkItem($slug, $type)
    {
        switch ($type) {
            case "video":
                $item = VideoRepo::getInstance()->find()->setSlug($slug)->build();
                $json = VideoRepo::getInstance()->find()->setSlug($slug)->setToJson()->build();
                break;
            case "album":
                $item = AlbumRepo::getInstance()->find()->setSlug($slug)->build();
                $json = AlbumRepo::getInstance()->find()->setSlug($slug)->setToJson()->build();
                break;
            case "playlist":
                $item = PlaylistRepo::getInstance()->find()->setSlug($slug)->build();
                $json = PlaylistRepo::getInstance()->find()->setSlug($slug)->setToJson()->build();
                break;
            default:
                $item = MusicRepo::getInstance()->find()->setSlug($slug)->build();
                $json = MusicRepo::getInstance()->find()->setSlug($slug)->setToJson()->build();
                break;
        }
        return [
            'item' => $item,
            'json' => $json
        ];
    }
}
