function shortenFileName(fileName, maxLength = 16) {
    const fileExtension = fileName.slice(fileName.lastIndexOf('.'));
    const baseName = fileName.slice(0, fileName.lastIndexOf('.'));

    if (fileName.length <= maxLength) {
        return fileName;
    }

    const availableLength = maxLength - fileExtension.length - 3;
    return baseName.slice(0, availableLength) + '...' + fileExtension;
}

function addListFile(fullFileName) {
    console.log(fullFileName);
    fetch('/cloud_storage/src/Controllers/ShareController.php', {
        method: 'POST',
        body: fullFileName,
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok. Status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log(data['path']);
        })
        .catch(error => {
            console.error('Проблема с запросом:', error);
        });
}



document.addEventListener('DOMContentLoaded', function () {
    fetch('/cloud_storage/src/Controllers/StorageController.php')
        .then(response => response.json())
        .then(data => {
            const fileList = document.getElementById('file-list');
            fileList.innerHTML = '';
            data.forEach(file => {
                const elementFile = document.createElement('div');
                const span = document.createElement('p');
                const img = document.createElement('img');
                img.src = '/cloud_storage/img/file.png';
                elementFile.classList.add('item-file');
                elementFile.setAttribute('data-fullname', file); // Сохраняем полное имя файла для дальнейшего использования
                span.textContent = shortenFileName(file); // Используем сокращенное имя для отображения в списке
                elementFile.appendChild(img);
                elementFile.appendChild(span);
                fileList.appendChild(elementFile);
            });

            const activeElements = document.querySelectorAll('.item-file');
            activeElements.forEach(element => {
                element.addEventListener('click', function () {
                    activeElements.forEach(el => el.style.backgroundColor = '');
                    element.style.backgroundColor = 'rgb(188, 190, 192)';
                    element.style.borderRadius = '10px';
                    const barManipulation = document.querySelector('.bar-manipulation');
                    barManipulation.style.display = 'flex';
                    const nameFile = document.querySelector('.filename');
                    let fullFileName = element.getAttribute('data-fullname'); // Получаем полное имя файла
                    let shortenedFileName = shortenFileName(fullFileName); // Получаем сокращенное имя для отображения
                    nameFile.textContent = shortenedFileName; // Отображаем сокращенное имя в панели управления
                    addListFile(fullFileName); // Вызываем функцию для обработки полного имени файла
                });
            });
        })
        .catch(error => {
            console.error('Ошибка:', error);
        });


    document.addEventListener('click', function (event) {
        const fileListElement = document.getElementById('file-list');
        const barManipulation = document.querySelector('.bar-manipulation');
        const isClickInsideBarManipulation = fileListElement.contains(event.target);
        const isClickInsideFileList = barManipulation.contains(event.target);
        if (!isClickInsideBarManipulation && !isClickInsideFileList) {
            barManipulation.style.display = 'none';
            const activeElements = document.querySelectorAll('.item-file');
            activeElements.forEach(el => el.style.backgroundColor = '');
        }
    });

    document.getElementById('shareFile').addEventListener('click', function (e) {
        e.preventDefault();
        fetch('/cloud_storage/src/Controller/ShareController.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/text/plain'
            }
                .then(responce => responce.text())
                .then(data => {
                    console.log(data)
                })
    })
})

    // document.getElementById('shareFile').addEventListener('click', function(e) {
    //     e.preventDefault();
    //     fetch('/cloud_storage/src/Controllers/ShareController.php', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'text/plain'
    //         }
    //     })
    //         .then(response => response.text())
    //         .then(data => {
    //             console.log(data);
    //         })
        // const linkCopy = document.querySelector('.filename').textContent;
        // const tempInput = document.createElement('input');
        // tempInput.style = 'position: absolute; left: -1000px; top: -1000px';
        // tempInput.value = linkCopy;
        // document.body.appendChild(tempInput);
        // tempInput.select();
        // document.execCommand('copy');
        // document.body.removeChild(tempInput);
        // alert('Слово "' + linkCopy + '" было скопировано в буфер обмена');
    });
// });
