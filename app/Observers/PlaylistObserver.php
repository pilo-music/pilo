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
        $musics = $playlist->musics()->get();

        foreach ($musics as $music) {
            $artist = $music->artist();
            $artists = $music->artists();

            $artist->increment('playlist_count');
            foreach ($artists as $item) {
                $item->increment('playlist_count');
            }
        }

        $playlist->stored_at = now();

        try {
            $playlist->addToIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the playlist "updated" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function updated(Playlist $playlist)
    {
        try {
            $playlist->updateIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the playlist "deleted" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function deleted(Playlist $playlist)
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

        try {
            $playlist->removeFromIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the playlist "restored" event.
     *
     * @param \App\Models\Playlist $playlist
     * @return void
     */
    public function restored(Playlist $playlist)
    {
        try {
            $playlist->addToIndex();
        } catch (\Exception $e) {
        }
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
}
