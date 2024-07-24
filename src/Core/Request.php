<?php

namespace App\src\Core;

class Request
{
    private string $method;
    private string $uri;
    private array $queryParams;
    private array $postParams;
    private array $headers;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = (parse_url($_SERVER['REQUEST_URI']))["path"];
        $this->queryParams = $_GET;
        $this->postParams = $_POST;
        $this->headers = getallheaders();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getPostParams(): array
    {
        return $this->postParams;
    }

    public function getAllHeaders(): array
    {
        return $this->headers;
    }
}