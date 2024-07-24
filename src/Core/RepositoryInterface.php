<?php

namespace App\src\Core;

interface RepositoryInterface
{
    public function getConnection();
    
    public function findAll();

    public function create(array $data);

    public function get(array $id);

    public function update(array $data);

    public function delete(array $id);
}