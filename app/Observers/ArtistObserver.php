<?php

namespace App\Observers;

use App\Models\Artist;

class ArtistObserver
{
    /**
     * Handle the artist "created" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function created(Artist $artist)
    {
        $artist->update([
            'stored_at' => now()
        ]);
    }

    /**
     * Handle the artist "updated" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function updated(Artist $artist)
    {

    }

    /**
     * Handle the artist "deleted" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function deleted(Artist $artist)
    {
    }

    /**
     * Handle the artist "restored" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function restored(Artist $artist)
    {

    }

    /**
     * Handle the artist "force deleted" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function forceDeleted(Artist $artist)
    {
        //
    }
}
