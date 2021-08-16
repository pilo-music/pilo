<?php

namespace App\Observers;

use App\Models\Music;

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
