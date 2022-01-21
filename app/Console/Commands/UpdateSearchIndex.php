<?php

namespace App\Console\Commands;

use App\Http\Repositories\V1\Album\AlbumRepo;
use App\Http\Repositories\V1\Artist\ArtistRepo;
use App\Http\Repositories\V1\Music\MusicRepo;
use App\Http\Repositories\V1\Playlist\PlaylistRepo;
use App\Http\Repositories\V1\Video\VideoRepo;
use App\Services\Rabbitmq\Listener;
use App\Services\Search\Search;
use Illuminate\Console\Command;

class UpdateSearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:search';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Listen to crud event and update search index';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        new Listener(
            queue: 'update_search',
            callback: function ($msg) {
                $body = $msg->body;
                $body = json_decode($body, true);
                $id = $body['id'];
                $type = $body['type'];
                $action = $body['action'];

                $item = match ($type) {
                    "music" => MusicRepo::getInstance()->find()->setId($id)->setColumns(["id", "title", "title_en"])->build(),
                    "artists" => ArtistRepo::getInstance()->find()->setId($id)->setColumns(["id", "title", "title_en"])->build(),
                    "album" => AlbumRepo::getInstance()->find()->setId($id)->setColumns(["id", "title", "title_en"])->build(),
                    "video" => VideoRepo::getInstance()->find()->setId($id)->setColumns(["id", "title", "title_en"])->build(),
                    "playlist" => PlaylistRepo::getInstance()->find()->setId($id)->setColumns(["id", "title"])->build(),
                    default => null,
                };

                if ($item) {
                    $search = new Search();
                    switch ($action) {
                        case "add":
                            $search->index->add($item->toArray(), $type);
                            break;
                        case "delete":
                            $search->index->delete($item->toArray(), $type);
                            break;
                        case "update":
                            $search->index->update($item->toArray(), $type);
                            break;
                    }
                }
            });
        return 0;
    }
}
