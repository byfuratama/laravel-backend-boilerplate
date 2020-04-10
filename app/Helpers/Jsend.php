<?php

namespace App\Helpers;

class Jsend
{
    private static $error_code = 500;
    private static $fail_code = 400;
    private static $success_code = 200;

    public static function error($message, $code = null, $data = null, $status = null, $extra_headers = [])
    {
        if (!$status) {
            $status = static::$error_code;
        }
        $response = [
            "status" => "error",
            "message" => $message
        ];
        !is_null($code) && $response['code'] = $code;
        !is_null($data) && $response['data'] = $data;

        return response()->json($response, $status, $extra_headers);
    }

    public static function fail($data, $status = null, $extra_headers = [])
    {
        if (!is_array($data)) {
            $data = ['message' => $data];
        }

        if (!$status) {
            $status = static::$fail_code;
        }
        $response = [
            "status" => "fail",
            "data" => $data
        ];

        return response()->json($response, $status, $extra_headers);
    }

    public static function success($data = [], $status = null, $extra_headers = [])
    {
        if (!is_array($data) && !is_object($data)) {
            $data = ['message' => $data];
        }

        if (!$status) {
            $status = static::$success_code;
        }
        $response = [
            "status" => "success",
            "data" => $data
        ];

        return response()->json($response, $status, $extra_headers);
    }

    public static function sendErrorInfo($errorInfo, $status = 400) {
        $message = sprintf("Error %s: %s", $errorInfo[1], $errorInfo[2]);
        return static::fail($message, $status);
    }
}
