<?php

namespace App\Console\Commands;

use App\Models\Artist;
use Illuminate\Console\Command;

class UpdateArtistStatics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'artist:update_statics';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update artist music_count,album_count,video_count,video_count,playlist_count';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $artists = Artist::all();
        $bar = $this->output->createProgressBar($artists->count());
        $bar->start();

        foreach ($artists as $artist) {
            $countMusic = $artist->musics()->count() + $artist->tagMusics()->count();
            $artist->music_count = $countMusic;
            $artist->save();

            $countAlbum = $artist->albums()->count() + $artist->tagAlbums()->count();
            $artist->album_count = $countAlbum;
            $artist->save();

            $countVideo = $artist->videos()->count() + $artist->tagVideos()->count();
            $artist->video_count = $countVideo;
            $artist->save();

            $bar->advance();
        }
        $bar->finish();
    }
}
