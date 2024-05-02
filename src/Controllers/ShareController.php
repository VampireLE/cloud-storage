<?php

namespace cloud_storage\src\Controllers;

use cloud_storage\src\Models\Users;
use Exception;

require_once __DIR__ . '/../../vendor/autoload.php';
class ShareController
{
    public function getPath(string $nameFile, string $namePerson)
    {
        $path = __DIR__ . "/../../files/$namePerson/";
        $files = scandir($path);

        foreach ($files as $file) {
            if ($file === $nameFile) {
                return $path . $file;
            }
        }
        // return false;

    }

    public function getLinkForFile(): void
    {
        header('Content-Type: application/json; charset=utf-8');


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $namePerson = $_COOKIE['login'];
        
            $nameFile = file_get_contents('php://input');
        
            $path = $this->getPath($nameFile, $namePerson);
            if ($path == false) {
                echo 'Файл отсутствует';
            }
            Users::generateAndSaveLink($namePerson, $path);
            echo json_encode(Users::getLink($namePerson, $path));
        } else {
            http_response_code(405);
            echo "Метод не поддерживается";
        }   
    }
}
$connectionToDataBase = new Users();
$shareController = new ShareController();
$shareController->getLinkForFile();