<?php

namespace App\Console\Commands;

use App\Services\Rabbitmq\Listener;
use Illuminate\Console\Command;

class UpdateCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to crud event and update caches';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        new Listener(
            queue: 'update_cache',
            callback: function ($msg) {
                $body = $msg->body;
                $body = json_decode($body, true);
                $id = $body['id'];
                $type = $body['type'];
                $action = $body['action'];

//                switch ($action) {
//                    case "delete":
//                        $search->index->delete($item->toArray(), $type);
//                        break;
//                    case "update":
//                        $search->index->update($item->toArray(), $type);
//                        break;
//                }

                $msg->ack();
            });
        return 0;
    }
}
