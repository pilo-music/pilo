<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mikehaertl\shellcommand\Command;

class HomeController extends Controller
{
    public function index()
    {
        echo 'ok';
        $command = "/usr/local/bin/deez-dw -l https://open.spotify.com/track/0SxjNrhMwarsbcgEy0pavJ -o /home/1587560780507190 /home/deezloader/setting.ini";
        $command = new Command($command);
        if (!$command->execute()) {
            dd($command->getOutput());
        }
        dd($command->getOutput());
    }

    public function test()
    {

    }
}
