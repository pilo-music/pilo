<?php

use App\Http\Controllers\Api\V1\AlbumController;
use App\Http\Controllers\Api\V1\ArtistController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BrowseController;
use App\Http\Controllers\Api\V1\FollowController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\LikeController;
use App\Http\Controllers\Api\V1\MessageController;
use App\Http\Controllers\Api\V1\MusicController;
use App\Http\Controllers\Api\V1\NotificationController;
use App\Http\Controllers\Api\V1\PlayHistoryController;
use App\Http\Controllers\Api\V1\PlaylistController;
use App\Http\Controllers\Api\V1\SearchController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\VersionController;
use App\Http\Controllers\Api\V1\VideoController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/landing', [HomeController::class, 'landing']);
Route::get('/share', [HomeController::class, 'share']);

Route::prefix('v1')->namespace('Api\V1')->group(function () {
    Route::post("/login", [AuthController::class, 'login']);
    Route::post("/verify", [AuthController::class, 'verify']);

    Route::get("/version", [VersionController::class, 'index']);

    Route::group(['middleware' => 'auth:sanctum'], function () {

        Route::get('/homes', [HomeController::class, 'index']);
        Route::get('/home', [HomeController::class, 'single']);

        Route::get('/browses', [BrowseController::class, 'index']);
        Route::get('/browse', [BrowseController::class, 'single']);

        Route::get('/search', [SearchController::class, 'search']);
        Route::post('/search/click', [SearchController::class, 'click']);

        Route::get('/musics', [MusicController::class, "index"]);
        Route::get('/music', [MusicController::class, 'single']);

        Route::get('/videos', [VideoController::class, "index"]);
        Route::get('/video', [VideoController::class, "single"]);

        Route::get('/artists', [ArtistController::class, "index"]);
        Route::get('/artist', [ArtistController::class, "single"]);

        Route::get('/playlists', [PlaylistController::class, "index"]);
        Route::get('/playlist', [PlaylistController::class, "single"]);

        Route::get('/albums', [AlbumController::class, "index"]);
        Route::get('/album', [AlbumController::class, "single"]);

        Route::post("/update", [UserController::class, 'update']);
        Route::post("/me", [UserController::class, "me"]);

        Route::post('/playlist/create', [PlaylistController::class, "create"]);
        Route::post('/playlist/edit', [PlaylistController::class, "edit"]);
        Route::post('/playlist/delete', [PlaylistController::class, "delete"]);
        Route::post('/playlist/music', [PlaylistController::class, "music"]);

        Route::post('/play-history', [PlayHistoryController::class, 'create']);

        Route::get('/likes', [LikeController::class, 'index']);
        Route::post('/like', [LikeController::class, 'like']);

        Route::get('/follows', [FollowController::class, 'index']);
        Route::post('/follow', [FollowController::class, "follow"]);

        Route::get('/messages', [MessageController::class, "index"]);
        Route::post('/message', [MessageController::class, "message"]);

        Route::get('/notifications', [NotificationController::class, "index"]);
    });
});
