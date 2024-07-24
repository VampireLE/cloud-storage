<?php

namespace App\src\Core;

class  Response
{
    public string $body;
    public $statusCode;

    public function setBody(string $body = ''): void
    {
        $this->body = $body;
    }

    public function setStatusCode(int $code = 200): void
    {
        $this->statusCode = $code;
    }

    public function addHeaders(string $header): void
    {
        header($header);
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        if (!file_exists($this->body)) {
            echo $this->body;
            return;
        }
        echo file_get_contents($this->body);
    }
}