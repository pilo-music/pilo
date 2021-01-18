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

        $music->update([
            'stored_at' => now()
        ]);

        try {
            $music->addToIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the music "updated" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function updated(Music $music)
    {
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

        try {
            $music->updateIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the music "deleted" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function deleted(Music $music)
    {
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

        try {
            $music->removeFromIndex();
        } catch (\Exception $e) {
        }
    }

    /**
     * Handle the music "restored" event.
     *
     * @param \App\Models\Music $music
     * @return void
     */
    public function restored(Music $music)
    {
        try {
            $music->addToIndex();
        } catch (\Exception $e) {
        }
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
}
