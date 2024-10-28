<?php

namespace App\src\Core\Db;

use App\src\Core\Db\Database;
use App\src\Core\Interface\RepositoryInterface;
use PDO;

class Users implements RepositoryInterface
{
    private $connect;

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
        var_dump($data);
        // $statement = $this->connect->prepare("INSERT INTO users (login, password, role_id) VALUES (:login, :password, :role_id)");
        // $statement->execute([
        //     ':login' => $data['login'],
        //     ':password' => $data['password'],
        //     ':role_id' => $data['role']
        // ]);
    }

    public function get(array $data): array|string
    {
        $statement = $this->connect->prepare("SELECT id FROM users WHERE login = :login");
        $statement->execute([':login' => $data['login']]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function update(array $data)
    {
        $statement = $this->connect->prepare("UPDATE users SET login = :login, password = :password, role_id = :role_id WHERE id = :id");
        $statement->execute([
            ':login' => $data['login'],
            ':password' => $data['password'],
            ':role_id' => $data['role'],
            ':id' => $data['id']
        ]);
    }

    public function delete(array $data): void
    {
        $statement = $this->connect->prepare("DELETE FROM users WHERE login = :login");
        $statement->execute([':login' => $data['login']]);
    }
}
