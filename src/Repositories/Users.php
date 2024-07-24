<?php

namespace App\src\Repositories;

use App\src\Core\RepositoryInterface;
use App\Config\Database;
use PDO;

class Users implements RepositoryInterface
{
    public $connect;

    public function __construct()
    {
        $this->connect = $this->getConnection();
    }

    public function getConnection(): object
    {
        $connection = Database::getInstance();
        if ($connection === null) {
            throw new \Exception('Не удалось подключиться к базе данных');
        }
        return $connection;
    }

    public function findAll(): array|string
    {
        $statement = $this->connect->prepare("SELECT * FROM users");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {
        $statement = $this->connect->prepare("INSERT INTO users (login, password) VALUES (:login, :password)");
        $statement->execute([
            ':login' => $data['login'],
            ':password' => $data['password']
        ]);
    }

    public function get(array $data): array|string
    {
        $statement = $this->connect->prepare("SELECT id FROM users WHERE login = :login");
        $statement->execute([':login' => $data['login']]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $data): void
    {
        $statement = $this->connect->prepare("UPDATE users SET login = :login, password = :password WHERE id = :id");
        $statement->execute([
            ':login' => $data['login'],
            ':password' => $data['password'],
            ':id' => $data['id']
        ]);
    }

    public function delete(array $id): void
    {
        $statement = $this->connect->prepare("DELETE FROM users WHERE id = :id");
        $statement->execute([':id' => $id]);
    }
}
