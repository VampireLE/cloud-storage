<?php

namespace App\Src\Services;

use App\src\Core\Setting;

class DeleteFileService
{
    public $storageRepository;

    public function __construct($storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }
    public function delete(object $request): string
    {
        $setting = new Setting();
        $path = $setting->get('app.paths.files_path');

        $fileName = json_decode(file_get_contents('php://input'))->fileName;
        
        $namePerson = explode('=', $request->getAllHeaders()['Cookie'])[1];

        $isFile = $this->storageRepository->fileExists(['nameFile' => $fileName]);
        
        if (file_exists($path . '/' . $namePerson . '/' . $fileName) && $isFile !== false) {
            $this->storageRepository->delete(['fileName' => $fileName]);
            
            unlink($path . '/' . $namePerson . '/' . $fileName);
            return 'Файл успешно удален';
        }
        throw new \Exception('Произошла ошибка при удалении файла ' . $fileName);
    }   
}