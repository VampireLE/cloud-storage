<?php

namespace App\Config;

use App\src\Core\Setting;
use PDO;

class Database
{
    public static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        $setting = new Setting();
        $database = $setting->get('app.database');

        if (self::$instance === null) {
            try {
                
                self::$instance = new PDO("mysql:host=localhost;dbname=cloud_storage;charset=utf8", 'root', '');
            } catch (\PDOException $error) {
                throw new \PDOException($error);
            }
        }

        return self::$instance;
    }
}