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

        try {
            $artist->addToIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the artist "updated" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function updated(Artist $artist)
    {
        try {
            $artist->updateIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the artist "deleted" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function deleted(Artist $artist)
    {
        try {
            $artist->removeFromIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the artist "restored" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function restored(Artist $artist)
    {
        try {
            $artist->addToIndex();
        } catch (\Exception $e) {
        }
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
