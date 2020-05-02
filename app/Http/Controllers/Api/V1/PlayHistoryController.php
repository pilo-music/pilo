<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Models\PlayHistory;
use Illuminate\Http\Request;

class PlayHistoryController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'type' => 'required|in:music,album,playlist,video',
        ]);

        $user = $request->user("api");


        switch ($request->type) {
            case "music":
                $item = MusicRepo::getInstance()->find()->setSlug($request->slug)->build();
                break;
            case "album":
                $item = AlbumRepo::getInstance()->find()->setSlug($request->slug)->build();
                break;
            case "playlist":
                $item = PlaylistRepo::getInstance()->find()->setSlug($request->slug)->build();
                break;
            case "video":
                $item = VideoRepo::getInstance()->find()->setSlug($request->slug)->build();
                break;
            default:
                $item = null;
                break;
        }

        if ($item) {
            $history = PlayHistory::query()->where("user_id", $user->id)
                ->where("historyable_id", $item->id)
                ->where("historyable_type", get_class($item))->latest()->first();

            if ($history && is_past("15", $history->created_at)) {
                $user->histories()->create([
                    'historyable_id' => $item->id,
                    'historyable_type' => get_class($item),
                    'ip' => get_ip(),
                    'agent' => $request->header('User-Agent')
                ]);
                $item->increment("play_count");
            } elseif (!$history) {
                $user->histories()->create([
                    'historyable_id' => $item->id,
                    'historyable_type' => get_class($item),
                    'ip' => get_ip(),
                    'agent' => $request->header('User-Agent')
                ]);
                $item->increment("play_count");
            }

        }

        return CustomResponse::create(null, '', true);
    }
}
