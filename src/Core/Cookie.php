<?php

namespace App\Src\Core;

class Cookie
{
    public function setCookie(Request $request): void
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