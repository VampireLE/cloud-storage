<?php

namespace App\src\Services;

use App\src\Core\Setting;

class DownloadFileService
{
    private $storageRepository;

    public function __construct($storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }
    public function download(object $request, object $response): void
    {
        $setting = new Setting();
        $path = $setting->get('app.paths.files_path');

        $nameFile = file_get_contents('php://input');

        $namePerson = explode('=', $request->getAllHeaders()['Cookie'])[1];

        if (file_exists($path . '/' . $namePerson . '/' . $nameFile)) {
            $response->addHeaders('Content-Description', 'File Transfer');
            $response->addHeaders('Content-Type', 'application/octet-stream');
            $response->addHeaders('Content-Disposition', 'attachment; filename="' . basename($path) . '"');
            $response->addHeaders('Expires', '0');
            $response->addHeaders('Cache-Control', 'must-revalidate');
            $response->addHeaders('Pragma', 'public');
            $response->addHeaders('Content-Length', (string)filesize($path . '/' . $namePerson . '/' . $nameFile));

            $response->send();
            readfile($path . '/' . $namePerson . '/' . $nameFile);
        }
    }
}
