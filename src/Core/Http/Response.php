<?php

namespace App\src\Core\Http;

class Response
{
    private string $body = '';
    private $statusCode;

    private array $headers = [];

    public function setBody(string $body = ''): void
    {
        $this->body = $body;
    }

    public function setStatusCode(int $code = 200): void
    {
        $this->statusCode = $code;
    }

    public function addHeaders(string $header, string $value): void
    {
        $this->headers[$header] = $value;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
        
        if (!empty($this->headers)) {
            foreach ($this->headers as $header => $value) {
                header("$header: $value");
            }
        }

        if (!file_exists($this->body)) {
            echo $this->body;
            return;
        }
        echo file_get_contents($this->body);
    }
}