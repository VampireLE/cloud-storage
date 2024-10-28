<?php

namespace App\src\Controllers\Client;

use App\src\Core\{
    Cookie,
    ServiceRegistry
};

class UserController
{
    private object $request;
    private object $response;

    public function __construct(object $response, object $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

    public function getService(string $nameService): object
    {
        ServiceRegistry::initializeServices();
        return ServiceRegistry::getService($nameService);
    }

    public function register(): void
    {
        
        $register = $this->getService('register');
        $data = (($this->request->getPostParams())['sign-up']);
        $data['role'] = false;
        
        $result = $register->userRegistration($data);
        
        if ($result !== 'Регистрация прошла успешно') {
            $this->response->setStatusCode(401);
            $this->response->setBody($result);
            $this->response->send();
            return;
        }

        $cookie = new Cookie();
        $cookie->setCookie($this->request);
        
        $this->response->setBody($result);
        $this->response->setStatusCode(200);
        $this->response->send();

        header('Location: /App/storage/');
    }

    public function login(): void
    {
        $auth = $this->getService('auth');
        $result = $auth->userAuthorisation(($this->request->getPostParams())['sign-in']);
    
        if ($result !== 'Авторизация прошла успешно') {
            $this->response->setStatusCode(401);
            $this->response->setBody($result);
            $this->response->send();
            return;
        }
        $cookie = new Cookie();
        $cookie->setCookie($this->request);

        $this->response->setBody($result);
        $this->response->setStatusCode(200);
        $this->response->send();

        header('Location: /App/storage/');
    }
}