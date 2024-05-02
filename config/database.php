<?php

namespace cloud_storage\Config;

use PDO;

require_once __DIR__ . '\\..\\vendor\\autoload.php';


class Database
{
    protected static ?object $connect = null;
    // protected static object $connect;

    // public function __construct()

    protected static function connectToDataBase(): void
    {
        try{
            self::$connect = new PDO("mysql:host=localhost;dbname=cloud_storage;charset=utf8", 'root', '');
        } catch(\PDOException $error) {
            echo 'Произошла ошибка с ' . $error->getMessage();
        }
    }
    public static function getConnect(): object
    {
        if (self::$connect == null) {
            self::connectToDataBase();
        }
        return self::$connect;
    }
}