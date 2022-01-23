<?php

namespace App\Observers;

use App\Models\Artist;
use App\Services\Rabbitmq\Publisher;

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

        new Publisher([
            'id' => $artist->id,
            'type' => 'artist',
            'action' => 'create'
        ], 'crud_models');
    }

    /**
     * Handle the artist "updated" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function updated(Artist $artist)
    {
        new Publisher([
            'id' => $artist->id,
            'type' => 'artist',
            'action' => 'update'
        ], 'crud_models');
    }

    /**
     * Handle the artist "deleted" event.
     *
     * @param Artist $artist
     * @return void
     */
    public function deleted(Artist $artist)
    {
        new Publisher([
            'id' => $artist->id,
            'type' => 'artist',
            'action' => 'delete'
        ], 'crud_models');
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
