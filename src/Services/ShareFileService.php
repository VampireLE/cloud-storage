<?php

namespace App\Src\Services;

use App\src\Core\Setting;
use App\Src\Repositories\FileStorage;

class ShareFileService
{
    public $storageRepository;

    public function __construct($storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    public function share($request): string
    {
        $getLink = $request->getUri();
        $splitLink = (explode('/', $getLink))[4];

        $fileName = $this->storageRepository->getFileName(['link' => $splitLink]);
        
        return $fileName['nameFile'];
    }

    public function download($request): void
    {
        $setting = new Setting();
        $path = $setting->get('app.paths.files_path');

        $link = file_get_contents('php//:input');

        
        $nameFile = $this->storageRepository->getFileName(['link' => $link]);

        $namePerson = explode('=', $request->getAllHeaders()['Cookie'])[1];

        if (file_exists($path . '/' . $namePerson . '/' . $nameFile)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            readfile($path . '/' . $namePerson . '/' . $nameFile);
        }
    }
}
