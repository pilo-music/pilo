<?php

namespace App\Http\Controllers\Api;

class CustomResponse
{
    public static function create($data, string $message, bool $status, $response_code = 200)
    {
        if (isset($data)) {
            return response()->json([
                "data" => $data,
                "message" => $message,
                "status" => $status,
            ], $response_code);
        }

        return response()->json([
            "data" => [],
            "message" => $message,
            "status" => $status,
        ], $response_code);
    }
}
