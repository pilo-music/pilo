<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Music;
use App\Models\Video;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'likeable_id' => 'required',
            'likeable_type' => 'required',
            'action' => 'required',
        ]);

        $user = auth()->user();
        $type = $this->getLikeType($request->likeable_type);

        $like = $user->likes()->where('likeable_id', $request->likeable_id)
            ->where('likeable_type', $type)
            ->first();

        if ($request->action == "add" && !$like) {
            $user->likes()->create([
                'likeable_id' => $request->likeable_id,
                "likeable_type" => $type
            ]);
        } elseif ($request->action == "remove" && $like) {
            $like->delete();
        }
        return CustomResponse::create(null, "", true);
    }

    public function list()
    {
        $user = auth()->user();
        $likes = $user->likes()->latest()->get();

        $return_info = [];
        foreach ($likes as $like) {
            if ($like->likeable_type == get_class(new Music())) {
                $item = Music::find($like->likeable_id);
                $type = "music";
            } else if ($like->likeable_type == get_class(new Video())) {
                $item = Video::find($like->likeable_id);
                $type = "video";
            } else {
                $item = Album::find($like->likeable_id);
                $type = "album";
            }
            $date = new Verta($like->created_at);
            $return_info[] = [
                'id' => $item->id,
                'type' => $type,
                'slug' => $item->slug,
                'title' => $item->title,
                'image' => $item->image,
                'created_at' => $date->formatDifference(),
                'artist' => [
                    'id' => $item->artist->id,
                    'name' => $item->artist->name,
                    'slug' => $item->artist->slug,
                ]
            ];
        }
        return CustomResponse::create($return_info, '', true);
    }


    private function getLikeType($param)
    {
        switch ($param) {
            case "video":
                $type = get_class(new Video());
                break;
            case "album":
                $type = get_class(new Album());
                break;
            default:
                $type = get_class(new Music());
                break;
        }
        return $type;
    }
}
