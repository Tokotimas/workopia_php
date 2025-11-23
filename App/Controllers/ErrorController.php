<?php

namespace App\Controllers;

class ErrorController
{
    /**
     * 404 not found error
     * 
     * @return void
     */
    public static function notFound($message = 'Resource not found'): void
    {
        http_response_code(response_code: 404);

        loadView(name: 'error', data: [
            'status' => '404',
            'message' => $message
        ]);
    }

    /**
     * 403 not authorized
     * 
     * @return void
     */
    public static function unauthorized($message = 'You are not authorized to view ths resource'): void
    {
        http_response_code(response_code: 403);

        loadView(name: 'error', data: [
            'status' => '403',
            'message' => $message
        ]);
    }
}