<?php

namespace App\src\Services;

class ShareFileService
{
    private $storageRepository;

    public function __construct($storageRepository)
    {
        $this->storageRepository = $storageRepository;
    }

    public function share($request): string
    {
        $getLink = $request->getUri();
        $splitLink = (explode('/', $getLink))[4];
        
        $fileName = ($this->storageRepository->getFileName(['link' => $splitLink]))['nameFile'];
        return $fileName;
    }
}
