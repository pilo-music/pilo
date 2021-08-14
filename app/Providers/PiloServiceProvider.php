<?php

namespace App\Providers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Music;
use App\Models\Playlist;
use App\Models\Search\EloquentSearchRepository;
use App\Models\Search\SearchRepository;
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

        Blade::componentNamespace('App\\View\\Components\\Admin\\UI', 'ui');


        Blade::component(Input::class);
        Blade::component(Button::class);

        Blade::component(Table::class);

        Blade::component(AlbumRow::class);
        Blade::component(MusicRow::class);


        $this->app->bind(SearchRepository::class, EloquentSearchRepository::class);
    }
}
