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
