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

    Route::get("/version", 'VersionController@index');

    Route::get('/homes', 'HomeController@index');
    Route::get('/home', 'HomeController@single');

    Route::get('/browses', 'BrowseController@index');
    Route::get('/browse', 'BrowseController@single');

    Route::get('/search', 'SearchController@search');
    Route::post('/search/click', 'SearchController@click');

    Route::get('/musics', 'MusicController@index');
    Route::get('/music', 'MusicController@single');

    Route::get('/videos', 'VideoController@index');
    Route::get('/video', 'VideoController@single');

    Route::get('/artists', 'ArtistController@index');
    Route::get('/artist', 'ArtistController@single');

    Route::get('/playlists', 'PlaylistController@index');
    Route::get('/playlist', 'PlaylistController@single');

    Route::get('/albums', 'AlbumController@index');
    Route::get('/album', 'AlbumController@single');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post("/update", 'UserController@update');
        Route::post("/me", 'UserController@me');

        Route::post('/playlist/create', 'PlaylistController@create');
        Route::post('/playlist/edit', 'PlaylistController@edit');
        Route::post('/playlist/delete', 'PlaylistController@delete');
        Route::post('/playlist/music', 'PlaylistController@music');


        Route::post('/play-history', 'PlayHistoryController@create');

        Route::get('/likes', 'LikeController@index');
        Route::post('/like', 'LikeController@like');

        Route::get('/bookmarks', 'BookmarkController@index');
        Route::post('/bookmark', 'BookmarkController@bookmark');

        Route::get('/follows', 'FollowController@index');
        Route::post('/follow', 'FollowController@follow');

        Route::get('/messages', 'MessageController@index');
        Route::post('/message', 'MessageController@message');


        Route::get('/notifications', 'NotificationController@index');

    });
});
