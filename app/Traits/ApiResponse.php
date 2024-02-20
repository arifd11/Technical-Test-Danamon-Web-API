<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected static $response = [
        'meta' => [
            'code' => 200,
            'status' => true,
            'message' => null,
        ],
        'data' => null
    ];
    
    public static function successResponse($data = null, $message = null, $code = 200) : JsonResponse
    {
        self::$response['meta']['message'] = $message;
        self::$response['meta']['code']    = $code;
        self::$response['data'] = $data;
        return response()->json(self::$response, self::$response['meta']['code']);
    }

    public static function errorResponse($data = null, $message = null, $code = 400) : JsonResponse
    {
        self::$response['meta']['status']  = false;
        self::$response['meta']['code']    = $code;
        self::$response['meta']['message'] = $message;
        self::$response['data']            = $data;
        return response()->json(self::$response, self::$response['meta']['code']);
    }
}
