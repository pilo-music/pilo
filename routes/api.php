<?php

use Illuminate\Http\Request;
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

Route::prefix('v1')->namespace('Api\V1')->group(function () {
//        Route::post("/login", 'ClientController@login');
//
//        Route::post("/verify", 'ClientController@verify');
//        Route::get("/version", 'VersionController@get');
//
//        Route::get('/vitrine', 'HomeController@home');
//        Route::get('/vitrine/single', 'HomeController@single');
//        Route::get('/search', 'SearchController@search');
//
//        Route::get('/music', 'MusicController@single');
//        Route::get('/musics', 'MusicController@get');
//
//        Route::get('/artist', 'ArtistController@single');
//        Route::get('/artists', 'ArtistController@get');
//
//        Route::get('/playlist', 'PlaylistController@single');
//        Route::get('/playlists', 'PlaylistController@get');
//        Route::get('/playlists/vitrine', 'PlaylistVitrineController@single');
//        Route::get('/playlists/vitrines', 'PlaylistVitrineController@home');

    Route::get('/album', 'AlbumController@single');
//        Route::get('/albums', 'AlbumController@get');

//        Route::get('/related', 'RelatedController@get');
//
//        Route::get('/plans', 'PlanController@get');
//
//        Route::post('/playcount/add', 'PlayCountController@add');

    Route::group(['middleware' => 'auth:api'], function () {
//            Route::post("/update", 'ClientController@update');
//            Route::post("/me", 'ClientController@me');
//
//            Route::get('/foryou', 'ForYouController@get');
//            Route::get('/foryou/playlists', 'ForYouController@playlists');
//            Route::get('/foryou/follows', 'ForYouController@follows');
//            Route::get('/foryou/likes', 'ForYouController@likes');
//
//            Route::post('/playcount/user/add', 'PlayCountController@add');
//
//            Route::post('/playlist/add', 'PlaylistController@add');
//            Route::post('/playlist/update', 'PlaylistController@update');
//            Route::post('/playlist/delete', 'PlaylistController@delete');
//            Route::post('/playlist/music', 'PlaylistController@music');
//
//            Route::get('/likes', 'LikeController@get');
//            Route::post('/like', 'LikeController@like');
//
//            Route::post('/follow', 'FollowController@follow');
//            Route::get('/follows', 'FollowController@get');
//
//            Route::get('/followers', 'FollowController@followers');
//            Route::get('/follow/artists', 'FollowController@artists');
//            Route::get('/follow/clients', 'FollowController@clients');
//            Route::get('/follow/playlists', 'FollowController@playlists');
//
//            Route::get('/sync-musics', 'SyncMusicController@get');
//            Route::post('/sync-music/add', 'SyncMusicController@add');
//            Route::post('/sync-music/delete', 'SyncMusicController@delete');
//
//            Route::get('/histories', 'PlayHistoryController@get');
//            Route::post('/history/add', 'PlayHistoryController@add');
//
//            Route::post('/payment/add', 'TransactionController@add');
//
//            Route::get('/notifications', 'NotificationController@get');

    });
});
