<?php

namespace App\Observers;

use App\Models\Music;

class MusicObserver
{
    /**
     * Handle the music "created" event.
     *
     * @param  \App\Models\Music  $music
     * @return void
     */
    public function created(Music $music)
    {
        //
    }

    /**
     * Handle the music "updated" event.
     *
     * @param  \App\Models\Music  $music
     * @return void
     */
    public function updated(Music $music)
    {
        //
    }

    /**
     * Handle the music "deleted" event.
     *
     * @param  \App\Models\Music  $music
     * @return void
     */
    public function deleted(Music $music)
    {
        //
    }

    /**
     * Handle the music "restored" event.
     *
     * @param  \App\Models\Music  $music
     * @return void
     */
    public function restored(Music $music)
    {
        //
    }

    /**
     * Handle the music "force deleted" event.
     *
     * @param  \App\Models\Music  $music
     * @return void
     */
    public function forceDeleted(Music $music)
    {
        //
    }
}
