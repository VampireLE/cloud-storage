<?php

require_once __DIR__ . '/../Models/Users.php';

class DownloadController
{
    public function downloadFile()
    {
        $queryParameter = file_get_contents('php://input');

        $file = (Users::getPathFromLink($queryParameter)['path']);
        $fileName = basename($file);
        error_log("Путь к файлу: " . $file);
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            flush();
            readfile($file);
            exit;
        } else {
            echo "Ошибка: Файл не найден."; 
            exit;
        }
    }
}
$connect = new Users();
$downloadFile = new DownloadController();
$downloadFile->downloadFile();
