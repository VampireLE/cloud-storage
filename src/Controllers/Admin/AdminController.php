<?php

namespace App\src\Controllers\Admin;

use App\src\Services\UserService;
use App\src\Core\Db\Users;
use App\src\Core\{
    Cookie,
    ServiceRegistry
};

class AdminController
{
    private object $request;
    private object $response;
    public function __construct(object $request, object $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getService(string $nameService)
    {
        ServiceRegistry::initializeServices();
        return ServiceRegistry::getService($nameService);
    }

    public function showUsers()
    {
        
    }

    public function create()
    {
        
    }

    public function update(): void
    {
        
    }

    public function delete(): void
    {
        
    }
}