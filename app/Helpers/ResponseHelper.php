<?php

namespace App\Helpers;

class ResponseHelper    
{
    /**
     * Return success response
     */
    public static function success(string $message, array $data = [])
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    /**
     * Return error response
     */
    public static function error(string $message, int $code)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}