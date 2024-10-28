<?php

namespace App\src\Services;

use App\src\Core\Setting;
use App\src\Repositories\{
    Users,
    FileStorage
};

class UploadFileService
{
    private $storageRepository;

    private object $userRepository;

    public function __construct(object $storageRepository, object $userRepository)
    {
        $this->storageRepository = $storageRepository;
        $this->userRepository = $userRepository;
    }

    public function send(object $request): void
    {
        $setting = new Setting();
        $path = $setting->get('app.paths.files_path');
        
        $generateLink = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
        $getLogin = ($request->getAllHeaders())['Cookie'];
        $namePerson = str_replace('login=', '', $getLogin);

        $getId = $this->userRepository->get(['login' => $namePerson]);
        
        $this->storageRepository->create([
            'link' => $generateLink,
            'path' => $path . $namePerson,
            'nameFile' => $_FILES['file']['name'],
            'userId' => $getId
        ]);

        move_uploaded_file($_FILES['file']['tmp_name'], $path . $namePerson . '/' . $_FILES['file']['name']);
        
        if (!file_exists($path . $namePerson . '/'  . $_FILES['file']['name'])) {
            throw new \Exception('Произошла ошибка при отправке файла на сервер');
        }
    }
    
}