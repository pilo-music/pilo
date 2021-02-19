<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use App\Http\Repositories\V1\Bookmark\BookmarkRepo;
use App\Http\Repositories\V1\Like\LikeRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Models\Music;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PlaylistController extends Controller
{

    public function index(Request $request)
    {
        /*
         * get params
         */
        $sort = request()->has('sort') ? request()->sort : Playlist::SORT_LATEST;
        $page = request()->has('page') ? request()->page : 1;
        $count = request()->has('count') ? request()->count : Playlist::DEFAULT_ITEM_COUNT;

        $data = PlaylistRepo::getInstance()->get()
            ->setUser($request->has('user') ? auth()->guard('api')->user() : null)
            ->setPage($page)
            ->setCount($count)
            ->setSort($sort)
            ->setToJson()
            ->build();

        return CustomResponse::create($data, '', true);
    }

    public function single(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:playlists,slug'
        ]);

        $playlist = PlaylistRepo::getInstance()->find()->setSlug($request->slug)
            ->setUser($request->has('user') ? auth()->guard('api')->user() : null)->build();

        if (!$playlist) {
            return abort(404);
        }

        /**
         * @todo make better related music
         */
        return CustomResponse::create([
            'playlist' => PlaylistRepo::getInstance()->toJson()->setPlaylist($playlist)->build(),
            'musics' => PlaylistRepo::getInstance()->musics()->setPlaylist($playlist)->setToJson()->build(),
            'has_like' => LikeRepo::getInstance()->has()->setUser($request->user("api"))->setItem($playlist)->build(),
            'has_bookmark' => BookmarkRepo::getInstance()->has()->setUser($request->user("api"))->setItem($playlist)->build(),
        ], '', true);
    }


    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|max:190',
            'image' => 'is_image'
        ]);

        /*
         * upload image
         */
        if ($request->has('image')) {
            $img = Image::make($request->get('image'));
            $img->resize(600, 600);
            $img->encode('jpg');
            $fileName = now()->timestamp . '_' . uniqid('', true) . '.' . explode('/', explode(':', substr($request->get('image'), 0, strpos($request->get('image'), ';')))[1])[1];
            Storage::disk('custom-ftp')->put('public_html/cover/' . $fileName, $img);
            $image = env('APP_URL', 'https://pilo.app') . '/cover/' . $fileName;
        } else {
            $image = null;
        }

        $user = $request->user();
        $playlist = $user->playlists()->create([
            'title' => $request->title,
            'slug' => now()->timestamp . uniqid('', true),
            'image' => $image,
            'music_count' => 0,
            'like_count' => 0,
            'play_count' => 0,
            'status' => Playlist::STATUS_ACTIVE,
        ]);

        if ($request->has('music_slug')) {
            $music = MusicRepo::getInstance()->find()->setSlug($request->music_slug)->build();
            if ($music) {
                DB::table('playlistables')->insert([
                    'playlistable_id' => $music->id,
                    'playlistable_type' => Music::class,
                    'playlist_id' => $playlist->id
                ]);
            }
            $playlist->update([
                'music_count' => 1
            ]);
        }

        PlaylistRepo::getInstance()->updateImage()->setPlaylist($playlist)->build();
        $data = PlaylistRepo::getInstance()->toJson()->setPlaylist($playlist)->build();
        return CustomResponse::create($data, __("messages.playlist_create"), true);
    }


    public function edit(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:playlists',
            'title' => 'required|max:190',
            'image_remove' => 'required|boolean',
            'image' => 'is_image'
        ]);


        $playlist = PlaylistRepo::getInstance()->find()->setSlug($request->slug)
            ->setUser($request->user())
            ->build();

        if (!$playlist) {
            return abort(404);
        }

        if ($request->has('image')) {
            $img = Image::make($request->get('image'));
            $img->resize(600, 600);
            $img->encode('jpg');
            $fileName = now()->timestamp . '_' . uniqid('', true) . '.' . explode('/', explode(':', substr($request->get('image'), 0, strpos($request->get('image'), ';')))[1])[1];
            Storage::disk('custom-ftp')->put('public_html/cover/' . $fileName, $img);
            $image = env('APP_URL', 'https://pilo.app') . '/cover/' . $fileName;
        } else $image = $playlist->image;


        if ($request->image_remove)
            $image = null;


        $playlist->update([
            'title' => $request->title,
            'image' => $image,
        ]);

        PlaylistRepo::getInstance()->updateImage()->setPlaylist($playlist)->build();
        $data = PlaylistRepo::getInstance()->toJson()->setPlaylist($playlist)->build();
        return CustomResponse::create($data, __("messages.playlist_update"), true);
    }

    public function delete(Request $request)
    {

        $request->validate([
            'slug' => 'required|exists:playlists,slug',
        ]);

        $user = $request->user();
        $playlist = PlaylistRepo::getInstance()
            ->find()->setSlug($request->slug)
            ->setUser($user)
            ->build();

        if (!$playlist) {
            abort(404);
        }

        $playlist->delete();

        return CustomResponse::create(null, __("messages.playlist_delete"), true);
    }

    public function music(Request $request)
    {
        $request->validate([
            'slug' => 'required|exists:playlists',
            'music_slug' => 'required',
            'action' => 'required|in:add,remove,list'
        ]);

        $user = $request->user();
        $playlist = PlaylistRepo::getInstance()
            ->find()->setSlug($request->slug)
            ->setUser($user)
            ->build();

        if (!$playlist) {
            abort(404);
        }


        if ($request->action == "list") {
            $data = PlaylistRepo::getInstance()->musics()->setPlaylist($playlist)->setToJson()->build();
            return CustomResponse::create($data, "", true);
        }


        /**
         * check music exists in playlist for detect action
         */

        $music_slugs = explode(',', $request->music_slug);
        foreach ($music_slugs as $slug) {
            if ($slug == "") {
                continue;
            }

            $musicDB = MusicRepo::getInstance()->find()->setSlug($slug)->build();
            if (!$musicDB) {
                continue;
            }

            $music_id = $musicDB->id;

            $music = DB::table('playlistables')->where('playlist_id', $playlist->id)
                ->where('playlistable_id', $music_id)
                ->where('playlistable_type', Music::class)->first();
            if ($music && $request->action == 'remove') {
                /**
                 * music exist so we delete it from playlist
                 */
                DB::table('playlistables')->where('playlist_id', $playlist->id)
                    ->where('playlistable_id', $music_id)
                    ->where('playlistable_type', Music::class)->delete();
            } else if (!$music && $request->action == 'add') {
                DB::table('playlistables')->insert([
                    'playlistable_id' => $music_id,
                    'playlistable_type' => Music::class,
                    'playlist_id' => $playlist->id
                ]);
            }
        }

        $playlist->update([
            'music_count' => $playlist->musics()->get()->count()
        ]);

        PlaylistRepo::getInstance()->updateImage()->setPlaylist($playlist)->build();
        $data = PlaylistRepo::getInstance()->toJson()->setPlaylist($playlist)->build();
        return CustomResponse::create($data, __("messages.playlist_update"), true);
    }
}
