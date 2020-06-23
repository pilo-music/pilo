<?php

namespace App\Observers;

use App\Models\Artist;

class ArtistObserver
{
    /**
     * Handle the artist "created" event.
     *
     * @param  \App\Models\Artist  $artist
     * @return void
     */
    public function created(Artist $artist)
    {
        $artist->stored_at = now();
    }

    /**
     * Handle the artist "updated" event.
     *
     * @param  \App\Models\Artist  $artist
     * @return void
     */
    public function updated(Artist $artist)
    {
        //
    }

    /**
     * Handle the artist "deleted" event.
     *
     * @param  \App\Models\Artist  $artist
     * @return void
     */
    public function deleted(Artist $artist)
    {
        //
    }

    /**
     * Handle the artist "restored" event.
     *
     * @param  \App\Models\Artist  $artist
     * @return void
     */
    public function restored(Artist $artist)
    {
        //
    }

    /**
     * Handle the artist "force deleted" event.
     *
     * @param  \App\Models\Artist  $artist
     * @return void
     */
    public function forceDeleted(Artist $artist)
    {
        //
    }
}
