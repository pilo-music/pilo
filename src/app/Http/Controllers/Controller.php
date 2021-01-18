<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public static function uploadFile($url, $path, $extension, $fileName = null)
    {
        $newName = $fileName == null ? md5($url) : $fileName;
//        $extraPath = now()->year . '-' . now()->month . '-' . now()->day;
//        $name = $path . '/' . $extraPath . '/' . $newName . '.' . $extension;
        $name = $path . '/' . $newName . '.' . $extension;
        Storage::disk('custom-ftp')->put('/public_html/' . $name, fopen($url, 'r'));
        return config('pilo.download_host_url') . '/' . $name;
    }

//    protected function uploadFile($file, $path): string
//    {
//        $extension = $file->getClientOriginalExtension();
//        $name = md5(now()->getTimestamp() . mt_rand(10000, 90000)) '.' . $extension;
//        Storage::disk('custom-ftp')->put('public_html/' . $path . '/' . $name, fopen($file, 'r+'));
//        return config('crawler.download_host_url') . '/' . $name;
//    }
}
