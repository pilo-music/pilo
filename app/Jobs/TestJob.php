<?php

namespace App\Jobs;

use App\Models\AdminMessages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use mikehaertl\shellcommand\Command;

class TestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $command = "/usr/local/bin/deez-dw -l https://open.spotify.com/track/0SxjNrhMwarsbcgEy0pavJ -o /home/1587560780507190 /home/deezloader/setting.ini";
        $command = new Command($command);
        if (!$command->execute()) {
            AdminMessages::create([
                'type' => AdminMessages::TYPE_ERROR,
                'user_id' => 1,
                'message' => $command->getError()
            ]);
        } else {
            AdminMessages::create([
                'type' => AdminMessages::TYPE_ERROR,
                'user_id' => 1,
                'message' => "ok"
            ]);
        }

    }
}
