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
use App\View\Components\Admin\Forms\Button;
use App\View\Components\Admin\Forms\Input;
use App\View\Components\Admin\Items\AlbumRow;
use App\View\Components\Admin\Items\MusicRow;
use App\View\Components\Admin\UI\Table;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Artist::observe(ArtistObserver::class);
        Music::observe(MusicObserver::class);
        Album::observe(AlbumObserver::class);
        Video::observe(VideoObserver::class);
        Playlist::observe(PlaylistObserver::class);

        Paginator::useBootstrap();
    }
}
