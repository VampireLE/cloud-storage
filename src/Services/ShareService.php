<?php

namespace App\src\Services;

use App\src\Core\Setting;


class ShareService
{
    private object $storageRepository;
    private object $userRepository;

    public function __construct(object $storageRepository, object $userRepository)
    {
        $this->storageRepository = $storageRepository;

        $this->userRepository = $userRepository;
    }

    public function share(object $request): string
    {
        $setting = new Setting();
        $path = $setting->get('app.paths.files_path');

        $userName = (explode('=',($request->getAllHeaders())['Cookie']))[1];
        $generateLink = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);

        $getId = $this->userRepository->get(['login' => $userName]);

        $nameFile = file_get_contents('php://input');
        
        $isFile = $this->storageRepository->fileExists(['nameFile' => $nameFile]);
        
        if ($isFile === false) {
            $this->storageRepository->create([
                'link' => $generateLink,
                'path' => $path . $userName,
                'nameFile' => $nameFile,
                'userId' => $getId
            ]);
        }

        $this->storageRepository->update(['link' => $generateLink, 'nameFile' => $nameFile]);
        return $generateLink;
    }
}