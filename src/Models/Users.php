<?php

namespace cloud_storage\src\Models;

use cloud_storage\config\Database;
use PDO;

require_once __DIR__ . '/../../vendor/autoload.php';


class Users
{
    public static object $connect;

    public function __construct()
    {
        self::$connect = Database::getConnect();
    }

    /*
    Проверяет, найдена ли запись пользователя
    @return bool true если запись найдена false если не найдена
    */
    public static function isUser($login, $password): bool
    {
        $result = self::$connect->prepare("SELECT id FROM users WHERE login = :login and password = :password");
        $result->execute([
            ':login' => $login,
            ':password' => $password,
        ]);
        return !is_bool($result->fetch(PDO::FETCH_ASSOC)) ? true : false;
    }

    public static function addUser($login, $password): bool
    {
        try {
            $statement = self::$connect->prepare("INSERT INTO users (login, password) VALUE(
                :login,
                :password
            )");
            $statement->execute([
                'login' => $login,
                'password' => $password,
            ]);
            return true;
        } catch (\PDOException $error) {
            echo 'Ошибка: ' . $error->getMessage();
            return false;
        }
    }

    public static function getIdUser($namePerson)
    {
        try {
            $statement = self::$connect->prepare("SELECT id FROM users WHERE login = :login");
            $statement->execute([
                ':login' => $namePerson
            ]);
            $result = ($statement->fetch(PDO::FETCH_ASSOC));
            return $result['id'];
        } catch (\PDOException $error) {
            echo 'Произошла ошибка с ' . $error->getMessage();
        }
    }

    public static function generateAndSaveLink($namePerson, $path)
    {
        $link = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
        $userId = self::getIdUser($namePerson);

        try {
            $selectStmt = self::$connect->prepare("SELECT link FROM share_files WHERE path = :path AND user_id = :user_id");
            $selectStmt->execute([
                ':path' => $path,
                ':user_id' => $userId
            ]);
            $existingLink = $selectStmt->fetchColumn();

            if ($existingLink) {

                $updateStmt = self::$connect->prepare("UPDATE share_files SET link = :link WHERE path = :path AND user_id = :user_id");
                $updateStmt->execute([
                    ':link' => $link,
                    ':path' => $path,
                    ':user_id' => $userId
                ]);
                return $link;
            } else {
                $insertStmt = self::$connect->prepare("INSERT INTO share_files (link, path, user_id) VALUES (:link, :path, :user_id)");
                $insertStmt->execute([
                    ':link' => $link,
                    ':path' => $path,
                    ':user_id' => $userId
                ]);
                return $link;
            }
        } catch (\PDOException $error) {
            echo $error->getMessage();
            return null;
        }
    }



    public static function getLink($namePerson, $path)
    {
        try {
            $statement = self::$connect->prepare("SELECT link, path FROM share_files WHERE user_id = :user_id and path = :path");
            $statement->execute([
                ':user_id' => self::getIdUser($namePerson),
                ':path' => $path
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $error) {
            return 'Произошла ошибка: ' . $error->getMessage();
        }
    }

    /*
    @param в метод getPathFromLink передается $queryParameter имя пользователя
    */

    public static function getPathFromLink($queryParameter)
    {
        try {
            $statement = self::$connect->prepare("SELECT path FROM share_files WHERE link = :link");
            $statement->execute([
                ':link' => $queryParameter
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            return $result['path'];
        } catch (\PDOException $error) {
            return 'Произошла ошибка ' . $error->getMessage();
        }
    }
}
