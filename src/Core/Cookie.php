<?php

namespace App\src\Core;

class Cookie
{
    public function setCookie(object $request): void
    {
        $getParams = ($request->getPostParams());
        $key = array_keys($getParams)[0];
        setcookie('login', $getParams[$key]['login']);
    }

    public function deleteCookie(): void
    {
        setcookie('user', '', time() - 3600, '/');
    }
}