<?php

namespace App\Src\Controllers;

use App\src\Core\{
    Response,
    Request,
    Cookie
};

use App\config\App;

class UserController
{
    public object $request;
    public object $response;

    public function __construct(Response $response, Request $request)
    {

        $this->response = $response;
        $this->request = $request;
        $data = $this->request->getPostParams();
        switch (array_keys($data)[0]) {
            case 'sign-up':
                $this->register($this->response, $this->request);
                break;
            case 'sign-in':
                $this->login($this->response, $this->request);
                break;
        }
    }

    public function getService(string $nameService): object
    {
        App::registrationService();
        return App::getService($nameService);
    }

    public function register(Response $response, Request $request): void
    {
        $register = $this->getService('register');
        $result = $register->userRegistration(($request->getPostParams())['sign-up']);
        if ($result !== 'Регистрация прошла успешно') {
            $response->setStatusCode(401);
            $response->setBody($result);
            $response->send();
            return;
        }

        $cookie = new Cookie();
        $cookie->setCookie($request);
        
        $response->setBody($result);
        $response->setStatusCode(200);
        $response->send();

        header('Location: /App/storage/');
    }

    public function login(Response $response, Request $request): void
    {
        $auth = $this->getService('auth');
        $result = $auth->userAuthorisation(($request->getPostParams())['sign-in']);
        
        if ($result !== 'Авторизация прошла успешно') {
            $response->setStatusCode(401);
            $response->setBody($result);
            $response->send();
            return;
        }
        $cookie = new Cookie();
        $cookie->setCookie($request);

        $response->setBody($result);
        $response->setStatusCode(200);
        $response->send();

        header('Location: /App/storage/');
    }
}