<?php

namespace App\Src\Services;

use App\src\Core\Setting;

class FileService
{
    public $listFiles = array();

    public function getFiles(object $request): array
    {
        $userName = (explode('=', ($request->getAllHeaders())['Cookie']))[1];

        $setting = new Setting();
        $paths = $setting->get('app.paths.files_path');

        $userDirectory = $paths . $userName . '/';

        if (!is_dir($userDirectory)) {
            throw new \Exception("Directory not found: " . $userDirectory);
        }

        $files = scandir($userDirectory);
        if ($files === false) {
            throw new \Exception("Failed to open directory: " . $userDirectory);
        }

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $this->listFiles[] = $file;
        }

        return $this->listFiles;
    }
}
