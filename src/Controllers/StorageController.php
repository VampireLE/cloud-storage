<?php

namespace App\Src\Controllers;

use App\src\Core\{
    Request,
    Response
};

use App\config\App;

class StorageController
{
    public object $request;
    public object $response;
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function getFiles(): void
    {
        App::registrationService();
        $files = (App::getService('loadStorage'));
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($files->getFiles($this->request)));
        $this->response->send();
    }

    public function sendFile(): void
    {
        App::registrationService();
        $file = App::getService('uploadFile');
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($file->send($this->request)));
        $this->response->send();
    }

    public function downloadFile(): void
    {
        App::registrationService();
        $file = App::getService('downloadFile');
        $file->download($this->request);
    }

    public function deleteFile(): void
    {
        App::registrationService();
        $file = App::getService('deleteFile');
        $file->delete($this->request);
    }

    public function share(): void
    {
        App::registrationService();
        $shareFile = App::getService('share');
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($shareFile->share($this->request)));
        $this->response->send();
    }

    public function getShareLink(): void
    {
        App::registrationService();
        $share = App::getService('shareFile');
        $this->response->setStatusCode(200);
        $this->response->setBody(json_encode($share->share($this->request)));
        $this->response->send();
    }
}