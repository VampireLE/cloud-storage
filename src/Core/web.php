<?php

namespace App\Src\Core;

use App\Src\Controllers\{
    StorageController,
    UserController,
};
use App\src\Core\{
    Request,
    Response,
    Router
};

$router = new Router();

$router->addRoute('GET', '/^\/App\/$/', function ($response) {
    $response->setBody(__DIR__ . '/../../resources/view/auth.html');
    $response->send();
});

$router->addRoute('GET', '/^\/App\/storage\/$/', function ($response) {
    $response->setBody(__DIR__ . '/../../resources/view/cloud-storage.html');
    $response->send();
});

$router->addRoute('GET', '/^\/App\/storage\/share\/([A-Za-z0-9]+)$/', function ($response) {
    $response->setBody(__DIR__ . '/../../resources/view/share.html');
    $response->send();
});

$router->addRoute('POST', '/^\/App\/sign-in$/', function (Response $response, Request $request) {
    $user = new UserController($response, $request);
});

$router->addRoute('POST', '/^\/App\/sign-up$/', function (Response $response, Request $request) {
    $user = new UserController($response, $request);
});

$router->addRoute('POST', '/^\/App\/storage\/$/', function (Response $response, Request $request) {
    $storage = new StorageController($request, $response);
    $storage->getFiles();
});

$router->addRoute('POST', '/^\/App\/storage\/uploadFile\/$/', function (Response $response, Request $request) {
    $file = new StorageController($request, $response);
    $file->sendFile();
});

$router->addRoute('POST', '/^\/App\/storage\/download\/$/', function (Response $response, Request $request) {
    $download = new StorageController($request, $response);
    $download->downloadFile();
});

$router->addRoute('POST', '/^\/App\/storage\/share\/$/', function (Response $response, Request $request) {
    $share = new StorageController($request, $response);
    $share->getShareLink();
});

$router->addRoute('POST', '/^\/App\/storage\/share\/([A-Za-z0-9]+)$/', function (Response $response, Request $request) {
    $shareFile = new StorageController($request, $response);
    $shareFile->share();
});

$router->addRoute('DELETE', '/^\/App\/storage\/delete\/$/', function (Response $response, Request $request) {
    $file = new StorageController($request, $response);
    $file->deleteFile();
});

$router->run();