<?php

namespace cloud_storage\src\Controllers;

require_once __DIR__ . '/../../vendor/autoload.php';

class DeleteController
{
    public string $user;
    public string $fileName;

    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            $this->fileName = file_get_contents("php://input");
        }
        $this->user = $_COOKIE['login'];
    }

    public function delete()
    {
        if (file_exists(__DIR__ . "/../../files/$this->user/$this->fileName")) {
            unlink(__DIR__ . "/../../files/$this->user/$this->fileName");
        }
    }
}

$deleteFile = new DeleteController();
$deleteFile->delete();