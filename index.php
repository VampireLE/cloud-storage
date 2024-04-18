<?php

class Route
{
    private $request;

    public function getUri()
    {
        return $this->request = $_SERVER['REQUEST_URI'];
    }

    public function routeToAddress(): void
    {
        $matches = false;

        if (preg_match('/cloud_storage\/storage\/share\/([A-Za-z0-9]+)/', $this->request, $matches) ? $matches[0] : '') {
            $matches = $matches[0];
        }
        
        switch($this->request) {
            case '/cloud_storage/':
                require_once('./resources/view/auth.html');
                break;
            case '/cloud_storage/storage/':
                require_once(__DIR__ . '/resources/view/cloud-storage.html');
                break;
            default:
                if ($matches) {
                    require_once(__DIR__ . '/resources/view/share.php');
                }
                http_response_code(404);
                break;
        }
    }
}

$route = new Route;
$route->getUri();
$route->routeToAddress();