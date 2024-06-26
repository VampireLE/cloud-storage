<?php


namespace cloud_storage\src\Controllers;

use cloud_storage\src\Models\Users;
require_once '/xampp/htdocs/cloud_storage/vendor/autoload.php';



// Поменять название файла и класса
class UsersController
{
    public array $dataLogin = array();

    public function __construct()
    {
        $this->processRequest();
    }

    public function processRequest(): array
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $this->dataLogin = [
                'login' => $_POST['sign-in']['login'],
                'password' => $_POST['sign-in']['password'],
            ];
        }
        return $this->dataLogin;        
    }

    public function authenticate(): void
    {
        if (empty(($this->dataLogin)['login']) || empty(($this->dataLogin)['password'])) {
            echo 'Введеный логин или пароль пуст';
            return;
        }

        if ((Users::isUser(($this->dataLogin)['login'], ($this->dataLogin)['password'])) == false) {
            echo 'Данная учетная запись не найдена';
            return;
        }
        // if (!isset($_COOKIE['login'])) {
        //     header('location:/cloud_storage');
        // }
        setcookie('login', (($this->dataLogin)['login']));
        header('location:/cloud_storage/storage/');
    }
}


$connectionToDataBase = new Users();

$user = new UsersController();
$user->authenticate();