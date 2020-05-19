<?php

namespace App\Observers;

use App\Models\Album;

class AlbumObserver
{
    /**
     * Handle the album "created" event.
     *
     * @param \App\Models\Album $album
     * @return void
     */
    public function created(Album $album)
    {
        $artist = $album->artist();
        $artists = $album->artists();

        $artist->increment('album_count');
        foreach ($artists as $item) {
            $item->increment('album_count');
        }
    }

    /**
     * Handle the album "updated" event.
     *
     * @param \App\Models\Album $album
     * @return void
     */
    public function updated(Album $album)
    {
        //
    }

    /**
     * Handle the album "deleted" event.
     *
     * @param \App\Models\Album $album
     * @return void
     */
    public function deleted(Album $album)
    {
        $artist = $album->artist();
        $artists = $album->artists();

        $artist->decrement('album_count');
        foreach ($artists as $item) {
            $item->increment('album_count');
        }
    }

    /**
     * Handle the album "restored" event.
     *
     * @param \App\Models\Album $album
     * @return void
     */
    public function restored(Album $album)
    {
        //
    }

    /**
     * Handle the album "force deleted" event.
     *
     * @param \App\Models\Album $album
     * @return void
     */
    public function forceDeleted(Album $album)
    {
        //
    }
}
