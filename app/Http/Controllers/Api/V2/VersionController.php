<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Api\CustomResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        $data = [
            'version' => setting('api.version', 0),
            'min_version' => setting('api.min_version', 0),
            'update_title' => setting('api.update_title', ''),
            'update_description' => setting('api.update_description', ''),
            'update_link' => setting('api.update_link', ''),
        ];
        return CustomResponse::create($data, '', true);
    }
}
