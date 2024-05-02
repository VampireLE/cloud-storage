<?php

namespace cloud_storage\src\Controllers;

use cloud_storage\src\Models\Users;
require_once __DIR__ . '/../../vendor/autoload.php';
class RegistrationController
{
    public array $dataRegister = array();

    public function __construct()
    {
        $this->processRequest();
    }

    public function processRequest(): array
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->dataRegister = [
                'login' => $_POST['sign-up']['login'],
                'password' => $_POST['sign-up']['password'],
                'confirm_password' => $_POST['sign-up']['confirm_password'],
            ];
        }
        return $this->dataRegister;
    }

    public function register(): void
    {
        if (empty(($this->dataRegister)['login']) || empty(($this->dataRegister)['password']) || empty(($this->dataRegister)['confirm_password'])) {
            echo 'Одно из полей регистрации не заполнено';
            return;
        }

        if (strlen($this->dataRegister['login']) < 10 || strlen($this->dataRegister['password']) < 10) {
            echo 'Длина логина или пароля должна быть больше 10 символов';
            return;
        }

        if ($this->dataRegister['password'] !== $this->dataRegister['confirm_password']) {
            echo 'Введеный пароль не совпадает';
            return;
        }

        if ((Users::isUser(($this->dataRegister)['login'], ($this->dataRegister)['password'])) == true) {
            echo 'Учетная запись с введеным логином и паролем уже существует введите другой логин';
            return;
        }

        if ((Users::addUser(($this->dataRegister)['login'], ($this->dataRegister)['password']) == false)) {
            echo 'Не удалось создать учетную запись';
            return;
        }
        setcookie('login', $this->dataRegister['login'], time() + 86400, '/');
        mkdir(__DIR__ . '/../../../cloud_storage/files/' . $this->dataRegister['login']);
        header('location:/cloud_storage/storage/');
    }
}

$connectionToDataBase = new Users();

$user = new RegistrationController();
$user->register();