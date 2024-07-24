<?php

namespace App\src\Services;

use Exception;

class ServiceContainer
{
    protected array $bindings = [];

    public function bind(string $id, $service): void
    {
        $this->bindings[$id] = $service;
    }

    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new Exception("Service not found $id");
        }

        return $this->bindings[$id];
    }

    public function has(string $id): bool
    {
        return isset($this->bindings[$id]);
    }
}