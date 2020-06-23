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

        $artist = $album->artist;
        $artists = $album->artists()->get();


        $artist->update([
            'album_count' => $artist->albums()->count() + $artist->tagAlbums()->count()
        ]);

        foreach ($artists as $item) {
            $artist->update([
                'album_count' => $item->albums()->count() + $item->tagAlbums()->count()
            ]);
        }

        $album->stored_at = now();
    }

    /**
     * Handle the album "updated" event.
     *
     * @param \App\Models\Album $album
     * @return void
     */
    public function updated(Album $album)
    {
        $artist = $album->artist;
        $artists = $album->artists()->get();


        $artist->update([
            'album_count' => $artist->albums()->count() + $artist->tagAlbums()->count()
        ]);

        foreach ($artists as $item) {
            $artist->update([
                'album_count' => $item->albums()->count() + $item->tagAlbums()->count()
            ]);
        }
    }

    /**
     * Handle the album "deleted" event.
     *
     * @param \App\Models\Album $album
     * @return void
     */
    public function deleted(Album $album)
    {
        $artist = $album->artist;
        $artists = $album->artists()->get();


        $artist->update([
            'album_count' => $artist->albums()->count() + $artist->tagAlbums()->count()
        ]);

        foreach ($artists as $item) {
            $artist->update([
                'album_count' => $item->albums()->count() + $item->tagAlbums()->count()
            ]);
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
