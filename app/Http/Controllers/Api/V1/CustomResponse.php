<?php


namespace App\Http\Controllers\Api\V1;


use Illuminate\Http\Response;

class CustomResponse
{
    const SUCCESS = "success";
    const ERROR = "error";

    public static function create($data, $status, $response_code = 200)
    {
        if (isset($data)) {
            return response()->json([
                "data" => $data,
                "status" => $status
            ], $response_code);
        }else{
            return response()->json([
                "status" => $status
            ], $response_code);
        }
    }
}