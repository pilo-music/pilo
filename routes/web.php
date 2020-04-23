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

use mikehaertl\shellcommand\Command;

Route::get('/', "HomeController@index");

Route::get('/test',function(){
    $command = "deez-dw -l https://open.spotify.com/track/0SxjNrhMwarsbcgEy0pavJ -o /home /home/deezloader/setting.ini";
    $command = new Command($command);
    if (!$command->execute()) {
        dd($command->getOutput());
    }
});
