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
            ], $response_code)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', '*')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', '86400')
                ->header('Access-Control-Allow-Headers', '*');
        }

        return response()->json([
            "data" => [],
            "message" => $message,
            "status" => $status,
        ], $response_code)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', '*')
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Max-Age', '86400')
            ->header('Access-Control-Allow-Headers', '*');
    }
}
