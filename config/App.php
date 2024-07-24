<?php

namespace App\config;

use App\src\Repositories\{
    FileStorage,
    Users
};
use App\Src\Services\{
    DeleteFileService,
    DownloadFileService,
    FileService,
    ServiceContainer,
    UserService,
    ShareService,
    UploadFileService,
    ShareFileService
};

class App
{
    public static object $container;

    public static function registrationService(): void
    {
        self::$container = new ServiceContainer();
        self::$container->bind('auth', new UserService(new Users()));
        self::$container->bind('register', new UserService(new Users()));
        self::$container->bind('loadStorage', new FileService());
        self::$container->bind('uploadFile', new UploadFileService(new FileStorage(), new Users()));
        self::$container->bind('downloadFile', new DownloadFileService(new FileStorage()));
        self::$container->bind('deleteFile', new DeleteFileService(new FileStorage()));
        self::$container->bind('shareFile', new ShareService(new FileStorage(), new Users()));
        self::$container->bind('share', new ShareFileService(new FileStorage()));
    }

    public static function getService(string $nameService): object
    {
        return self::$container->get($nameService);
    }
}
