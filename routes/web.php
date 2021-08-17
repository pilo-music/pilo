<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Admin\AuthController;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "https://pilo.app");

Route::get('/policy', "HomeController@policy");

Route::prefix('ohmygod')->middleware('auth')->namespace('Admin')->group(static function () {
    Route::get('/', 'IndexController')->name('admin.index');
    Route::get('/home', 'IndexController')->name('home');

    Route::resource('artists', 'ArtistController');
    Route::resource('musics', 'MusicController');
    Route::resource('albums', 'AlbumController');
    Route::resource('videos', 'VideoController');
});


Route::get('ohmygod/login', [AuthController::class, 'show'])->name("login");
Route::post('ohmygod/login', [AuthController::class, 'login'])->name("login.post");


Route::get('test', function () {
    $client = ClientBuilder::create()->setHosts([
        "elasticsearch"
    ])->build();


//    $params = [
//        'index' => 'musics',
//        'body' => [
//            'settings' => [
//                'number_of_shards' => 2,
//                'number_of_replicas' => 0
//            ]
//        ]
//    ];
//
//    $response = $client->indices()->create($params);


    $music = \App\Models\Music::query()->select(["id", "title", "title_en"])->first();
    $response = $client->index([
        'index' => $music->getTable(),
        'id' => $music->getKey(),
        "body" => [
            "id" => 1,
            "title" =>""
        ],
    ]);


//    $params = [
//        'index' => $music->getTable(),
//        'id'    => $music->getKey()
//    ];
//
//    $response = $client->get($params);

    $params = [
        'index' => $music->getTable(),
        'body' => [
            'query' => [
                'match' => [
                    'title' => 'Se'
                ]
            ]
        ]
    ];

    $response = $client->search($params);

    dd($response);
});
