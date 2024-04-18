<?php

class StorageController
{
    public function processRequest(): void
    {
        header('Content-Type: application/json');
        $list = [];
        $login = $_COOKIE['login'];
        $path = __DIR__ . "/../../files/$login/";
        $data = scandir($path);

        foreach ($data as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $list[] = $file;
        }
        echo json_encode($list);
    }
}

$storageController = new StorageController();
$storageController->processRequest();