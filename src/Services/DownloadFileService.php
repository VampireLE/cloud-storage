<?php

namespace App\src\Services;

use App\src\Core\Setting;

class DownloadFileService
{
    public $storageRepository;

    public function __construct($storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }
    public function download(object $request): void
    {
        $setting = new Setting();
        $path = $setting->get('app.paths.files_path');

        $link = file_get_contents('php://input');
        
        $namePerson = explode('=', $request->getAllHeaders()['Cookie'])[1];

        $file = $this->storageRepository->getFileName(['link' => $link]);

        if (file_exists($path . '/' . $namePerson . '/' . $file)) {
            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path . '/' . $namePerson . '/' . $file);
        }
    }
}
