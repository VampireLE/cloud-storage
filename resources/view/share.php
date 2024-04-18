<?php
require_once __DIR__ . '/../../src/Models/Users.php';

$request = $_SERVER['REQUEST_URI'];
$requestCut = explode('/', $request);
$connectionToDataBase = new Users();
$result = (Users::getPathFromLink($requestCut[4]));
$path = $result[0]['path'];
$path = explode('/', $path);
$fileName = $path[5]; 

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShareFile</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        body {
            width: 100%;
            height: 100vh;
            background-color: rgb(235, 240, 255);
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        section {
            width: 700px;
            height: 700px;
            background-color: rgb(118, 118, 209);
            border-radius: 90px;
        }
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .file-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .file-container p {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
        }

        .container button {
            margin-top: 45px;
            width: 300px;
            height: 50px;
            border-radius: 20px;
            border: 0;
            cursor: pointer;
            font-size: 25px;
        }

        .container button:hover {
            box-shadow: rgb(75, 75, 92) 0px 7px 29px 0px;
        }

        .container button:active {
            margin-top: 40px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    
    <section>
        <div class="container">
            <div class="file-container">
                <img src="/cloud_storage/img/file.png" alt="ShareFile">
                <p class="nameFile"><?php echo $fileName ?></p>
            </div>
            <button>Download</button>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            //будем брать из скрипта php квери параметр в виде ссылки,
            //получать из нее путь до файла и отображать название файла
            //и передавать кнопке download в случае если она будет нажата скачивать файл на компьютер
            fetch()
            .then(responce => responce.text())
            .then(data => {

            });
        });
    </script>
</body>
</html>