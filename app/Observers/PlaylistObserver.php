<?php

namespace App\Observers;

use App\Models\Playlist;

class PlaylistObserver
{
    /**
     * Handle the playlist "created" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function created(Playlist $playlist)
    {
        $this->update($playlist);
        $playlist->update([
            'stored_at' => now()
        ]);

    }

    /**
     * Handle the playlist "updated" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function updated(Playlist $playlist)
    {
        $this->update($playlist);

    }

    /**
     * Handle the playlist "deleted" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function deleted(Playlist $playlist)
    {
        $this->update($playlist);
    }

    /**
     * Handle the playlist "restored" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function restored(Playlist $playlist)
    {

    }

    /**
     * Handle the playlist "force deleted" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function forceDeleted(Playlist $playlist)
    {
        //
    }


    public function update($playlist)
    {
        $musics = $playlist->musics()->get();

        foreach ($musics as $music) {
            $artist = $music->artist();
            $artists = $music->artists();

            $artist->decrement('playlist_count');
            foreach ($artists as $item) {
                $item->decrement('playlist_count');
            }
        }
    }
}
