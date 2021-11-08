<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Music;
use App\Models\User;
use App\Models\Video;

class IndexController extends Controller
{
    public function __invoke()
    {
        $music_count = Music::query()->where('status', Music::STATUS_ACTIVE)->count();
        $artist_count = Artist::query()->where('status', Artist::STATUS_ACTIVE)->count();
        $user_count = User::query()->where('level', 'user')->count();
        $album_count = Album::query()->where('status', Album::STATUS_ACTIVE)->count();
        $video_count = Video::query()->where('status', Video::STATUS_ACTIVE)->count();

        $musics = Music::query()->latest('stored_at')->get()->take(5);
        $videos = Video::query()->latest('stored_at')->get()->take(5);
        $albums = Album::query()->latest('stored_at')->get()->take(5);
        $artists = Artist::query()->latest('stored_at')->get()->take(5);

        $data = compact('music_count', 'artist_count', 'user_count', 'album_count', 'video_count', 'musics', 'albums', 'videos', 'artists');
        return view('admin.pages.index.index', $data);
    }
}
