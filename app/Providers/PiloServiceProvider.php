<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\Video;
use App\Observers\AlbumObserver;
use App\Observers\ArtistObserver;
use App\Observers\MusicObserver;
use App\Observers\PlaylistObserver;
use App\Observers\VideoObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class PiloServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('custom', function ($data, string $message, bool $status, $responseCode = 200) {
            return response()->json([
                "data" => $data,
                "message" => $message,
                "status" => $status,
            ], $responseCode);
        });



        Artist::observe(ArtistObserver::class);
        Music::observe(MusicObserver::class);
        Album::observe(AlbumObserver::class);
        Video::observe(VideoObserver::class);
        Playlist::observe(PlaylistObserver::class);

        Paginator::useBootstrap();
    }
}
