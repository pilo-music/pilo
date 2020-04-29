<?php

namespace App\Observers;

use App\Models\Playlist;

class PlaylistObserver
{
    /**
     * Handle the playlist "created" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function created(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "updated" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function updated(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "deleted" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function deleted(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "restored" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function restored(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "force deleted" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function forceDeleted(Playlist $playlist)
    {
        //
    }
}
