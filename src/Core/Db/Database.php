<?php

namespace App\src\Core\Db;

use App\src\Core\Setting;
use PDO;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        $setting = new Setting();
        $database = $setting->get('app.database');

        if (self::$instance === null) {
            try {
                self::$instance = new PDO(
                    'mysql:host=' . $database['host'] . ';' .
                    'dbname=' . $database['dbname'] . ';' .
                    'charset=' . $database['charset'],
                    $database['login'],
                    $database['password']
                );
            } catch (\PDOException $error) {
                throw new \PDOException($error);
            }
        }

        return self::$instance;
    }
}