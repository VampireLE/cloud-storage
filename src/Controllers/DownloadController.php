<?php

class TestController
{

    private string $fileName;

    private string $namePerson;
    public function __construct()
    {
        $this->namePerson = $_COOKIE['login'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->fileName = file_get_contents("php://input");
        }
    }

    public function searchFile()
    {
        $path = __DIR__ . "/../../files/$this->namePerson/$this->fileName";
        if (!file_exists($path)) {
            'Файл отсутствует';
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $this->fileName . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($path));
        flush();
        readfile($path);
        exit;
    }
}

$dowload = new TestController();
$dowload->searchFile();
