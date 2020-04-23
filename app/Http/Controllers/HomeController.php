<?php

namespace App\Http\Controllers;

use App\Jobs\TestJob;
use Illuminate\Http\Request;
use mikehaertl\shellcommand\Command;

class HomeController extends Controller
{
    public function index()
    {
       TestJob::dispatch();
    }

    public function test()
    {

    }
}
