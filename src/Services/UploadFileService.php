<?php

namespace App\Src\Services;

use App\src\Core\Setting;
use App\Src\Repositories\{
    Users,
    FileStorage
};

class UploadFileService
{
    /*
    *   Получаем хедерсы, куки (логин пользователя), собираем в одно и отправляем в бд
    *   имя файла, id пользователя чей файл. И отправить сам файл в папку files
    */

    // public $response; 
    // public $request;
    // public function __construct(Response $response, Request $request)
    // {
    //     $this->request = $request;
    //     $this->response = $response;
    // }
    public $storageRepository;

    public object $userRepository;

    public function __construct($storageRepository, object $userRepository)
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