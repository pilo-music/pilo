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

use Illuminate\Support\Facades\Auth;

Route::get('/', "HomeController@index");

//Route::get('/login/google', 'Panel\UserController@redirectToProvider');
//Route::get('/login/google/callback', 'Panel\UserController@handleProviderCallback');
//


Route::prefix('admin')->middleware('auth')->namespace('Admin')->group(static function () {
    Route::get('/', 'IndexController')->name('admin.index');
    Route::get('/home', 'IndexController')->name('home');
    Route::resource('artists', 'ArtistController');
    Route::resource('musics', 'MusicController');
    Route::resource('albums', 'AlbumController');
    Route::resource('videos', 'VideoController');
});


Auth::routes(['reset' => false, 'register' => false, 'forgot' => false, 'confirm' => false]);

