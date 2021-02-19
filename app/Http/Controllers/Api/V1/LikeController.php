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
    public function like(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'type' => 'required|in:music,album,playlist,video',
            'action' => 'required|in:add,remove',
        ]);

        $user = auth()->user();
        $item = $this->getLikeItem($request->slug, $request->type);

        if (!$item['item']) {
            abort(404);
        }

        $like = $user->likes()->where('likeable_id', $item['item']->id)
            ->where('likeable_type', get_class($item['item']))
            ->first();

        if ($request->action == "add" && !$like) {
            $user->likes()->create([
                'likeable_id' => $item['item']->id,
                "likeable_type" => get_class($item['item'])
            ]);
        } elseif ($request->action == "remove" && $like) {
            $like->delete();
        }
        return CustomResponse::create($item['json'], "", true);
    }

    public function index()
    {
        $user = auth()->user();
        $page = \request()->page ?? 1;
        $count = \request()->count ?? 15;

        $likes = $user->likes()->skip(($page - 1) * $count)->take($count)->get();

        $data = [];
        foreach ($likes as $like) {
            if ($like->likeable_type == get_class(new Music())) {
                $item = MusicRepo::getInstance()->find()->setId($like->likeable_id)->setToJson()->build();
            } else if ($like->likeable_type == get_class(new Video())) {
                $item = VideoRepo::getInstance()->find()->setId($like->likeable_id)->setToJson()->build();
            } elseif ($like->likeable_type == get_class(new Playlist())) {
                $item = PlaylistRepo::getInstance()->find()->setId($like->likeable_id)->setToJson()->build();
            } else {
                $item = AlbumRepo::getInstance()->find()->setId($like->likeable_id)->setToJson()->build();
            }
            if (!$item) {
                continue;
            }
            $type = explode("\\", $like->likeable_type);
            $data[] = [
                'item' => $item,
                'type' => strtolower($type[count($type) - 1]),
                'created_at' => Jalalian::forge($like->created_at)->ago()
            ];
        }
        return CustomResponse::create($data, '', true);
    }


    private function getLikeItem($slug, $type)
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
