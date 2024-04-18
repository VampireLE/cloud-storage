<?php
class Database
{
    protected static $connect;

    protected static function connectToDataBase()
    {
        try{
            self::$connect = new PDO("mysql:host=localhost;dbname=cloud_storage;charset=utf8", 'root', '');
        } catch(\PDOException $error) {
            echo 'Произошла ошибка с ' . $error->getMessage();
        }
    }
    public static function getConnect()
    {
        if (self::$connect == null) {
            self::connectToDataBase();
        }
        return self::$connect;
    }
}