<?php

namespace App\Services\Contracts;

abstract class BaseService
{
    public function resolve($response)
    {
        echo (json_encode($response));
    }

    public function reject($response)
    {
        http_response_code(500);
        header("Status: 500 Internal Server Error");
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode($response));
    }
}
