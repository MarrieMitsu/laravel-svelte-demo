<?php

namespace App\Errors;

class ServerError
{
    public int $code;
    public string $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }
}
