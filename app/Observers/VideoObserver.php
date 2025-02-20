<?php

namespace App\Observers;

use App\Models\Video;

class VideoObserver
{
    /**
     * Handle the video "created" event.
     *
     * @param \App\Models\Video $video
     * @return void
     */
    public function created(Video $video)
    {
        $this->update($video);
        $video->update([
            'stored_at' => now()
        ]);
    }

    /**
     * Handle the video "updated" event.
     *
     * @param \App\Models\Video $video
     * @return void
     */
    public function updated(Video $video)
    {
        $this->update($video);
    }

    /**
     * Handle the video "deleted" event.
     *
     * @param \App\Models\Video $video
     * @return void
     */
    public function deleted(Video $video)
    {
        $this->update($video);
    }

    /**
     * Handle the video "restored" event.
     *
     * @param \App\Models\Video $video
     * @return void
     */
    public function restored(Video $video)
    {
    }

    /**
     * Handle the video "force deleted" event.
     *
     * @param \App\Models\Video $video
     * @return void
     */
    public function forceDeleted(Video $video)
    {
        //
    }

    private function update($video){
        $artist = $video->artist;
        $artists = $video->artists()->get();


        $artist->update([
            'video_count' => $artist->videos()->count() + $artist->tagVideos()->count()
        ]);

        foreach ($artists as $item) {
            $artist->update([
                'video_count' => $item->videos()->count() + $item->tagVideos()->count()
            ]);
        }
    }
}
