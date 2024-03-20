<?php

namespace App\Http\Responses;

class NotificationResponse
{
    public static function info(string $message)
    {
        return [
            'type' => 'info',
            'message' => $message,
        ];
    }

    public static function success(string $message)
    {
        return [
            'type' => 'success',
            'message' => $message,
        ];
    }

    public static function warning(string $message)
    {
        return [
            'type' => 'warning',
            'message' => $message,
        ];
    }

    public static function error(string $message)
    {
        return [
            'type' => 'error',
            'message' => $message,
        ];
    }
}
