<?php

namespace cloud_storage\resources\view;
/**
 * requestCut переменная в которой лежит автогенерируемая ссылка
 * $path путь до файла
 * $result получаем имя файла
 */
use cloud_storage\src\Models\Users;
require_once __DIR__ . '\\..\\..\\vendor\\autoload.php';

$request = $_SERVER['REQUEST_URI'];
$requestCut = explode('/', $request);
$connectionToDataBase = new Users();

$path = (Users::getPathFromLink($requestCut[4]));
$result = explode('/', $path);
$fileName = $result[5];
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
                <p class="nameFile"><?php  echo $fileName ?></p>
            </div>
            <button class="downloadFile">Download</button>
        </div>
    </section>

    <script>

        document.querySelector('.downloadFile').addEventListener('click', function (e) {
            e.preventDefault();
            let url = window.location.href;
            let getLastUri = (url.split('/')).pop();
            fetch('/cloud_storage/src/Controllers/DownloadController.php', {
                method: 'POST',
                body: getLastUri
            })
            .then(respoce => respoce.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                a.download = '<?php echo $fileName; ?>';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            })
            .catch(error => console.error('Ошибка при загрузке файла:', error));
        });

    </script>
</body>
</html>