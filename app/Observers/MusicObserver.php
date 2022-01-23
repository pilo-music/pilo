<?php

namespace App\Observers;

use App\Models\Music;
use App\Services\Rabbitmq\Publisher;

class MusicObserver
{
    /**
     * Handle the music "created" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function created(Music $music)
    {
        $this->update($music);
        $music->update([
            'stored_at' => now()
        ]);

        new Publisher([
            'id' => $music->id,
            'type' => 'music',
            'action' => 'create'
        ], 'crud_models');
    }

    /**
     * Handle the music "updated" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function updated(Music $music)
    {
        $this->update($music);

        new Publisher([
            'id' => $music->id,
            'type' => 'music',
            'action' => 'update'
        ], 'crud_models');
    }

    /**
     * Handle the music "deleted" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function deleted(Music $music)
    {
        $this->update($music);

        new Publisher([
            'id' => $music->id,
            'type' => 'music',
            'action' => 'delete'
        ], 'crud_models');
    }

    /**
     * Handle the music "restored" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function restored(Music $music)
    {
    }

    /**
     * Handle the music "force deleted" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function forceDeleted(Music $music)
    {
        //
    }

    private function update($music){
        $artist = $music->artist;
        $artists = $music->artists()->get();


        $artist->update([
            'music_count' => $artist->musics()->count() + $artist->tagMusics()->count()
        ]);

        foreach ($artists as $item) {
            $artist->update([
                'music_count' => $item->musics()->count() + $item->tagMusics()->count()
            ]);
        }
    }
}
