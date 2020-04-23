<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function test()
    {
        echo 'ok';
        $command = "deez-dw -l https://open.spotify.com/track/0SxjNrhMwarsbcgEy0pavJ -o /home /home/deezloader/setting.ini";
        $command = new Command($command);
        if (!$command->execute()) {
            dd($command->getOutput());
        }
        dd($command->getOutput());
    }
}
