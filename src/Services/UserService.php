<?php

namespace App\src\Services;

use App\src\Core\Setting;

class UserService
{
    private object $userRepositories;

    public function __construct(object $userRepositories)
    {
        $this->userRepositories = $userRepositories;
    }

    public function userAuthorisation(array $data): string
    {
        if (empty($data['login']) || empty($data['password'])) {
            return 'Поле логина или пароля пустые';
        }

        if (($this->userRepositories->get($data)) === false || empty($this->userRepositories->get($data))) {
            return 'Данная учетная запись не существует';
        }
        return 'Авторизация прошла успешно';
    }

    public function userRegistration(array $data): string
    {
        if (empty($data['login']) || empty($data['password']) || empty($data['confirm_password'])) {
            return 'Одно из полей не заполнено';
        }

        if ($data['password'] !== $data['confirm_password']) {
            return 'Пароли не совпадают';
        }

        if (strlen($data['login']) < 10 || strlen($data['password']) < 10) {
            return 'Длина логина или пароля должна быть больше 10 символов';
        }

        if ($this->userRepositories->get($data)) {
            return 'Учетная запись с введенным логином уже существует, введите другой логин';
        }

        $setting = new Setting();
        $path = $setting->get('app.paths.files_path');

        $this->userRepositories->create($data);
        
        mkdir($path . $data['login']);
        return 'Регистрация прошла успешно';
    }
}
