<?php

class UploadController
{
    //
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namePerson = $_COOKIE['login'];
    move_uploaded_file($_FILES['file']['tmp_name'], __DIR__ . "/../../files/$namePerson/" . $_FILES['file']['name']);
}
