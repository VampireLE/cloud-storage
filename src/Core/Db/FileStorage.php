<?php

namespace App\src\Core\Db;

use App\src\Core\Interface\RepositoryInterface;
use App\src\Core\Db\Database;
use Exception;
use PDO;


class FileStorage implements RepositoryInterface
{
    private $connect;

    public function __construct()
    {
        $this->connect = $this->getConnection();
    }

    public function getConnection(): object
    {
        $this->connect = Database::getInstance();
        if ($this->connect === null) {
            throw new \Exception('Не удалось подключиться к базе данных');
        }
        return $this->connect; 
    }
    
    public function findAll(): array
    {
        try {

            $statement = $this->connect->prepare("SELECT * FROM users");
            $statement->execute();

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (\Exception $error) {
            return array('message' => $error->getMessage());
        }
    }

    public function create(array $data): array
    {

        try {
            $statement = $this->connect->prepare("INSERT INTO share_files (link, path, user_id, nameFile) VALUES (
                :link, :path, :user, :nameFile
            )");
            $statement->execute([
                ':link' => $data['link'],
                ':path' => $data['path'],
                ':user' => $data['userId']['id'],
                ':nameFile' => $data['nameFile']
            ]);
            return array('message' => 'Файл успешно создан');
        } catch (\Exception $error) {
            return array($error->getMessage());
        }
    }

    public function get(array $data): array
    {
        try {
            $statement = $this->connect->prepare("SELECT id, link, path, user FROM users WHERE user = :login");
            $statement->execute([
                ':login' => $data['login']
            ]);

            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;

        } catch (\Exception $error) {
            return array($error->getMessage());
        }
    }

    public function getFileName(array $data): array
    {
        try {
            $statement = $this->connect->prepare("SELECT nameFile FROM share_files WHERE link = :link");
            $statement->execute([
                ':link' => $data['link']
            ]);
            
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $error) {
            return array($error->getMessage());
        }
    }

    public function fileExists(array $data)
    {
        try {
            $statement = $this->connect->prepare("SELECT nameFile FROM share_files WHERE nameFile = :nameFile");
            $statement->execute([
                ':nameFile' => $data['nameFile']
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (\Exception $error) {
            return array($error->getMessage());
        }
    }

    public function update(array $data): array
    {
        try {
            $statement = $this->connect->prepare("UPDATE share_files SET link = :link WHERE nameFile = :nameFile");
            $statement->execute([
                ':link' => $data['link'],
                ':nameFile' => $data['nameFile']
            ]);
            return array('message' => 'Файл успешно обновился');
        } catch (\Exception $error) {
            return array($error->getMessage());
        }
    }

    public function delete(array $data): array
    {
        try {
            $statement = $this->connect->prepare("DELETE FROM share_files WHERE nameFile = :nameFile");
            $statement->execute([
                ':nameFile' => $data['nameFile']
            ]);
            return array('message' => 'Файл успешно удалился');
        } catch (\Exception $error) {
            return array('message' => $error->getMessage());
        }
    }
}