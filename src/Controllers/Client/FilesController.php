<?php

namespace App\Src\Controllers\Client;

use App\src\Core\ServiceRegistry;

class FilesController
{
    private object $request;
    private object $response;
    public function __construct(object $request, object $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getFiles(): void
    {
        ServiceRegistry::initializeServices();
        $files = (ServiceRegistry::getService('loadStorage'));
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($files->getFiles($this->request)));
        $this->response->send();
    }

    public function sendFile(): void
    {
        ServiceRegistry::initializeServices();
        $file = ServiceRegistry::getService('uploadFile');
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($file->send($this->request)));
        $this->response->send();
    }

    public function downloadFile(): void
    {
        ServiceRegistry::initializeServices();
        $file = ServiceRegistry::getService('downloadFile');
        $file->download($this->request, $this->response);
    }

    public function deleteFile(): void
    {
        ServiceRegistry::initializeServices();
        $file = ServiceRegistry::getService('deleteFile');
        $file->delete($this->request);
    }

    public function share(): void
    {
        ServiceRegistry::initializeServices();
        $shareFile = ServiceRegistry::getService('share');
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($shareFile->share($this->request)));
        $this->response->send();
    }

    public function getShareLink(): void
    {
        ServiceRegistry::initializeServices();
        $share = ServiceRegistry::getService('shareFile');
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($share->share($this->request)));
        $this->response->send();
    }
}