<?php

namespace App\routes;

use App\src\Controllers\Client\{
    UserController,
    FilesController
};

use App\src\Controllers\Admin\{
    UserController as UC
};

use App\src\Core\Http\{
    Request,
    Response
};

use App\src\Core\Router;

$router = new Router();

$router->addRoute('GET', '/^\/App\/$/', function ($response) {
    $response->setBody(__DIR__ . '/../resources/view/auth.html');
    $response->send();
});

$router->addRoute('GET', '/^\/App\/storage\/$/', function ($response) {
    $response->setBody(__DIR__ . '/../resources/view/cloud-storage.html');
    $response->send();
});

$router->addRoute('GET', '/^\/App\/storage\/share\/([A-Za-z0-9]+)$/', function ($response) {
    $response->setBody(__DIR__ . '/../resources/view/share.html');
    $response->send();
});

$router->addRoute('GET', '/^\/App\/admin-panel$/', function ($response) {
    $response->setBody(__DIR__ . '/../resources/view/admin-panel.html');
    $response->send();
});

$router->addRoute('POST', '/^\/App\/sign-in$/', function (Response $response, Request $request) {
    $user = new UserController($response, $request);
    $user->login();
});

$router->addRoute('POST', '/^\/App\/sign-up$/', function (Response $response, Request $request) {
    $user = new UserController($response, $request);
    $user->register();
});

$router->addRoute('POST', '/^\/App\/storage\/$/', function (Response $response, Request $request) {
    $storage = new FilesController($request, $response);
    $storage->getFiles();
});

$router->addRoute('POST', '/^\/App\/storage\/uploadFile\/$/', function (Response $response, Request $request) {
    $file = new FilesController($request, $response);
    $file->sendFile();
});

$router->addRoute('POST', '/^\/App\/storage\/download\/$/', function (Response $response, Request $request) {
    $download = new FilesController($request, $response);
    $download->downloadFile();
});

$router->addRoute('POST', '/^\/App\/storage\/share\/$/', function (Response $response, Request $request) {
    $share = new FilesController($request, $response);
    $share->getShareLink();
});

$router->addRoute('POST', '/^\/App\/storage\/share\/([A-Za-z0-9]+)$/', function (Response $response, Request $request) {
    $shareFile = new FilesController($request, $response);
    $shareFile->share();
});

$router->addRoute('POST', '/^\/App\/admin-panel\/$/', function (Response $response, Request $request) {
    $showUsers = new UC($request, $response);
    $showUsers->showUsers();
});

$router->addRoute('POST', '/^\/App\/admin-panel\/create\/$/', function (Response $response, Request $request) {
    $user = new UC($request, $response);
    $user->create();
});

$router->addRoute('POST', '/^\/App\/admin-panel\/update\/$/', function (Response $response, Request $request) {
    $user = new UC($request, $response);
    $user->update();
});

$router->addRoute('DELETE', '/^\/App\/admin-panel\/delete\/$/', function (Response $response, Request $request) {
    $newUser = new UC($request, $response);
    $newUser->delete();
});

$router->addRoute('DELETE', '/^\/App\/storage\/delete\/$/', function (Response $response, Request $request) {
    $file = new FilesController($request, $response);
    $file->deleteFile();
});

$router->run();