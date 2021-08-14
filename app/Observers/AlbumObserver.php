<?php

namespace App\Observers;

use App\Models\Album;

class AlbumObserver
{
    /**
     * Handle the album "created" event.
     *
     * @param Album $album
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

        $album->update([
            'stored_at' => now()
        ]);

        try {
            $album->addToIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the album "updated" event.
     *
     * @param Album $album
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

        try {
            $album->update();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the album "deleted" event.
     *
     * @param Album $album
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

        try {
            $album->removeFromIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the album "restored" event.
     *
     * @param Album $album
     * @return void
     */
    public function restored(Album $album)
    {
        try {
            $album->addToIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the album "force deleted" event.
     *
     * @param Album $album
     * @return void
     */
    public function forceDeleted(Album $album)
    {
    }
}
