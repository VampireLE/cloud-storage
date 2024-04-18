<?php

require_once __DIR__ . '/../../config/database.php';


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
            $statement = self::$connect->prepare("INSERT INTO users (id,  login, password) VALUE(
                null,
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

    public static function generateAndSaveLink($namePerson, $path)
    {
        $link = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
    
        try {
            $statement = self::$connect->prepare("UPDATE users SET share = :share, path = :path WHERE login = :login");
            $statement->execute([
                ':login' => $namePerson,
                ':share' => $link,
                ':path' => $path
            ]);
            return $link;
        } catch (\PDOException $error) {
            echo $error->getMessage();
            return;
        }
    }

    public static function getLinkAndPath(string $namePerson)
    {
        try{
            $statement = self::$connect->prepare("SELECT share, path FROM users WHERE login = :login");
            $statement->execute([
                ':login' => $namePerson
            ]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as $r) {
                return $r;
            }
        } catch (\PDOException $error) {
            return 'Произошла ошибка: ' . $error->getMessage();
        }
    }

    public static function getPathFromLink($queryParameter)
    {
        try {
            $statement = self::$connect->prepare("SELECT path FROM users WHERE share = :share");
            $statement->execute([
                ':share' => $queryParameter
            ]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $error) {
            return 'Произошла ошибка ' . $error->getMessage();
        }
    }
}