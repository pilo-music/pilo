<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\Video;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class LikeController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'type' => 'required|in:music,album,playlist,video',
            'action' => 'required|in:add,remove',
        ]);

        $user = auth()->user();
        $item = $this->getLikeItem($request->slug, $request->type);

        if (!$item) {
            abort(404);
        }

        $like = $user->likes()->where('likeable_id', $item->id)
            ->where('likeable_type', get_class($item))
            ->first();

        if ($request->action == "add" && !$like) {
            $user->likes()->create([
                'likeable_id' => $item->id,
                "likeable_type" => get_class($item)
            ]);
        } elseif ($request->action == "remove" && $like) {
            $like->delete();
        }
        return CustomResponse::create(null, "", true);
    }

    public function index()
    {
        $user = auth()->user();
        $likes = $user->likes()->latest()->get();

        $return_info = [];
        foreach ($likes as $like) {
            if ($like->likeable_type == get_class(new Music())) {
                $item = MusicRepo::getInstance()->find()->setId($like->likeable_id)->build();
                $type = "music";
            } else if ($like->likeable_type == get_class(new Video())) {
                $item = VideoRepo::getInstance()->find()->setId($like->likeable_id)->build();
                $type = "video";
            } elseif ($like->likeable_type == get_class(new Playlist())) {
                $item = PlaylistRepo::getInstance()->find()->setId($like->likeable_id)->build();
                $type = "playlist";
            } else {
                $item = AlbumRepo::getInstance()->find()->setId($like->likeable_id)->build();
                $type = "album";
            }
            if (!$item){
                continue;
            }
            $return_info[] = [
                'id' => $item->id,
                'type' => $type,
                'slug' => $item->slug,
                'title' => $item->title,
                'image' => $item->image,
                'created_at' => Jalalian::forge($item->created_at)->ago(),
                'artist' => [
                    'id' => $item->artist->id,
                    'name' => $item->artist->name,
                    'slug' => $item->artist->slug,
                ]
            ];
        }
        return CustomResponse::create($return_info, '', true);
    }


    private function getLikeItem($slug, $type)
    {
        switch ($type) {
            case "video":
                $item = VideoRepo::getInstance()->find()->setSlug($slug)->build();
                break;
            case "album":
                $item = AlbumRepo::getInstance()->find()->setSlug($slug)->build();
                break;
            case "playlist":
                $item = PlaylistRepo::getInstance()->find()->setSlug($slug)->build();
                break;
            default:
                $item = MusicRepo::getInstance()->find()->setSlug($slug)->build();
                break;
        }
        return $item;
    }
}
