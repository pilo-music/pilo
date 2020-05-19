<?php

namespace App\Observers;

use App\Models\Video;

class VideoObserver
{
    /**
     * Handle the video "created" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function created(Video $video)
    {
        $artist = $video->artist();
        $artists = $video->artists();

        $artist->increment('video_count');
        foreach ($artists as $item) {
            $item->increment('video_count');
        }
    }

    /**
     * Handle the video "updated" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function updated(Video $video)
    {
        //
    }

    /**
     * Handle the video "deleted" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function deleted(Video $video)
    {
        $artist = $video->artist();
        $artists = $video->artists();

        $artist->decrement('video_count');
        foreach ($artists as $item) {
            $item->decrement('video_count');
        }
    }

    /**
     * Handle the video "restored" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function restored(Video $video)
    {
        //
    }

    /**
     * Handle the video "force deleted" event.
     *
     * @param  \App\Models\Video  $video
     * @return void
     */
    public function forceDeleted(Video $video)
    {
        //
    }
}
