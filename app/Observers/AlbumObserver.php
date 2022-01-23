<?php

namespace App\Observers;

use App\Models\Album;
use App\Services\Rabbitmq\Publisher;
use Illuminate\Support\Facades\Artisan;

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
        $this->update($album);
        $album->update([
            'stored_at' => now()
        ]);

        new Publisher([
            'id' => $album->id,
            'type' => 'album',
            'action' => 'create'
        ], 'crud_models');
    }

    /**
     * Handle the album "updated" event.
     *
     * @param Album $album
     * @return void
     */
    public function updated(Album $album)
    {
        $this->update($album);

        new Publisher([
            'id' => $album->id,
            'type' => 'album',
            'action' => 'update'
        ], 'crud_models');
    }

    /**
     * Handle the album "deleted" event.
     *
     * @param Album $album
     * @return void
     */
    public function deleted(Album $album)
    {
        $this->update($album);

        new Publisher([
            'id' => $album->id,
            'type' => 'album',
            'action' => 'delete'
        ], 'crud_models');
    }

    /**
     * Handle the album "restored" event.
     *
     * @param Album $album
     * @return void
     */
    public function restored(Album $album)
    {

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


    private function update($album)
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
}
