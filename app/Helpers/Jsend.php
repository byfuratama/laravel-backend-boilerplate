<?php

namespace App\Helpers;

class Jsend
{
    private static $errorCode = 500;
    private static $failCode = 400;
    private static $successCode = 200;

    public static function error($message, $code = null, $data = null, $status = null, $extraHeaders = [])
    {
        if (!$status) {
            $status = static::$errorCode;
        }
        $response = [
            "status" => "error",
            "message" => $message
        ];
        !is_null($code) && $response['code'] = $code;
        !is_null($data) && $response['data'] = $data;

        return response()->json($response, $status, $extraHeaders);
    }

    public static function fail($data, $status = null, $extraHeaders = [])
    {
        if (!$status) {
            $status = static::$failCode;
        }
        $response = [
            "status" => "fail",
            "data" => $data
        ];

        return response()->json($response, $status, $extraHeaders);
    }

    public static function success($data = [], $status = null, $extraHeaders = [])
    {
        if (!$status) {
            $status = static::$successCode;
        }
        $response = [
            "status" => "success",
            "data" => $data
        ];

        return response()->json($response, $status, $extraHeaders);
    }
}
