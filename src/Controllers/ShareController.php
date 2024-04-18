<?php

require_once __DIR__ . '/../Models/Users.php';

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
        return false;
    }

    public function getLinkForFile()
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
            echo json_encode(Users::getLinkAndPath($namePerson));
        } else {
            http_response_code(405);
            echo "Метод не поддерживается";
        }   
    }
}
$connectionToDataBase = new Users();
$shareController = new ShareController();
$shareController->getLinkForFile();