<?php

namespace Src\Services\Admin\Entity;

use App\src\Core\Db\Users;

class EntityService
{

    public function showUsers()
    {
        $db = new Users();
        $result = $db->findAll();
        echo json_encode($result);
    }

    public function create()
    {
        $data = (json_decode(file_get_contents('php://input')));

        $userService = new UserService(new Users());
        echo($userService->userRegistration([
            'login'=>($data[0])->login,
            'password'=>($data[0])->password,
            'confirm_password'=>($data[0])->confirm_password,
            'role' => ($data[0])->role
        ]));
    }

    public function update(): void
    {
        $data = json_decode(file_get_contents('php://input'));

        $db = new Users();
        $idUser = $db->get(['login' => $data[0]->login]);
        
        $db->update([
            'login' => $data[0]->login,
            'password' => $data[0]->password,
            'role' => $data[0]->role,
            'id' => $idUser
        ]);
    }

    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'));
        $db = new Users();
        $db->delete(['login' => $data[0]->login]);

        rmdir(__DIR__ . './../../../files/' . $data[0]->login);
    }
}