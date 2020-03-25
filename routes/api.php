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
    Route::post("/login", 'AuthController@login');
    Route::post("/register", 'AuthController@register');
    Route::post("/verify", 'AuthController@verify');

    Route::post('/forgot-passport/create', 'ForgotPasswordController@create');
    Route::post('/forgot-passport/reset', 'ForgotPasswordController@reset');

//        Route::get("/version", 'VersionController@get');
//
    Route::get('/homes', 'HomeController@index');
    Route::get('/home', 'HomeController@single');
//        Route::get('/search', 'SearchController@search');
//
    Route::get('/musics', 'MusicController@index');
    Route::get('/music', 'MusicController@single');
//
    Route::get('/artists', 'ArtistController@index');
    Route::get('/artist', 'ArtistController@single');

    Route::get('/playlists', 'PlaylistController@index');
    Route::get('/playlist', 'PlaylistController@single');

    Route::get('/albums', 'AlbumController@index');
    Route::get('/album', 'AlbumController@single');

//        Route::post('/playcount/add', 'PlayCountController@add');

    Route::group(['middleware' => 'auth:api'], function () {
//            Route::post("/update", 'UserController@update');
        Route::post("/me", 'UserController@me');
//
//            Route::get('/foryou', 'ForYouController@get');
//            Route::get('/foryou/playlists', 'ForYouController@playlists');
//            Route::get('/foryou/follows', 'ForYouController@follows');
//            Route::get('/foryou/likes', 'ForYouController@likes');
//
//            Route::post('/playcount/user/add', 'PlayCountController@add');
//
            Route::post('/playlist/create', 'PlaylistController@create');
            Route::post('/playlist/edit', 'PlaylistController@edit');
            Route::post('/playlist/delete', 'PlaylistController@delete');
            Route::post('/playlist/music', 'PlaylistController@music');
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

//            Route::get('/notifications', 'NotificationController@get');

    });
});
