<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Models\Follow;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:artists',
            'action' => 'required|in:add,remove',
        ]);

        $artist = ArtistRepo::getInstance()->find()->setSlug($request->slug)->build();

        if (!$artist)
            abort(404);

        $user = $request->user();

        if ($request->action == "add") {
            Follow::query()->where('user_id', $user->id)
                ->where('artist_id', $artist->id)
                ->firstOrCreate([
                    'user_id' => $user->id,
                    'artist_id' => $artist->id
                ]);
        } else {
            Follow::query()->where('user_id', $user->id)
                ->where('artist_id', $artist->id)
                ->delete();
        }

        $data = ArtistRepo::getInstance()->toJson()->setArtist($artist)->build();

        return CustomResponse::create($data, '', true);

    }

    public function index()
    {
        $user = auth()->user();
        $data = [];
        foreach ($user->follows()->get() as $item) {
            $artist = ArtistRepo::getInstance()->find()->setId($item->artist_id)->setToJson()->build();
            if ($artist) {
                $data[] = [
                    'created_at' => Jalalian::forge($item->created_at)->ago(),
                    'artist' => $artist
                ];
            }
        }

        return CustomResponse::create($data, '', true);
    }
}
