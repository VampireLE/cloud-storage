function shortenFileName(fileName, maxLength = 16) {
    const fileExtension = fileName.slice(fileName.lastIndexOf('.'));
    const baseName = fileName.slice(0, fileName.lastIndexOf('.'));

    if (fileName.length <= maxLength) {
        return fileName;
    }

    const availableLength = maxLength - fileExtension.length - 3;
    return baseName.slice(0, availableLength) + '...' + fileExtension;
}

function shareBtnClick() {
    document.getElementById('shareFile').addEventListener('click', (event) => {
        event.preventDefault();

        let getFileName = document.querySelector('.active-file');
        let fullFileName = getFileName.getAttribute('data-fullname');

        fetch('/cloud_storage/src/Controllers/ShareController.php', {
            method: 'POST',
            body: fullFileName,
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(responce => responce.json())
            .then(data => {
                writeValue = document.createElement('input');
                writeValue.value = 'https://localhost/cloud_storage/storage/share/' + data['link'];
                document.body.appendChild(writeValue);
                writeValue.select();
                document.execCommand('copy');
                alert('В буффер обмена была скопирована ссылка на файл');
                writeValue.remove();
            })
            .catch(error => {
                console.log('Произошла ошибка с: ' + error);
            });
    });
}

function deleteFile() {
    document.getElementById('deleteFile').addEventListener('click', (event) => {
        event.preventDefault();

        const fileName = document.querySelector('.active-file').getAttribute('data-fullname');
        fetch('/cloud_storage/src/Controllers/DeleteController.php', {
            method: 'DELETE',
            body: fileName,
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Ошибка: ', error)
            })
    })
}

function downloadFile() {
    document.querySelector('.DownloadFile').addEventListener('click', (event) => {
        event.preventDefault(); //отменняет пееход на другую страницу

        // Получаем полное название файла из data-fullname
        let fileName = document.querySelector('.active-file').getAttribute('data-fullname');

        fetch('/cloud_storage/src/Controllers/DownloadController.php', {
            method: 'POST',
            body: fileName,
            headers: {
                'Content-Type': 'text/plain'
            }
        })
            .then(response => response.blob())
            .then(data => {
                const url = window.URL.createObjectURL(data);
                const a = document.createElement('a');
                a.href = url;
                a.download = fileName;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);
            });
    });
}


function UploadFile() {
    const formUploadFile = document.getElementById('uploadFiles');
    formUploadFile.addEventListener('submit', (event) => {
        event.preventDefault();

        const file = (formUploadFile.querySelector('[type="file"]')).files[0];
        const formatData = new FormData();
        formatData.append('file', file);

        fetch('/cloud_storage/src/Controllers/UploadController.php', {
            method: 'POST',
            body: formatData
        })
            .then(response => response.text())
            .then(data => {
                console.log(data);
            })
    })
}

document.addEventListener('DOMContentLoaded', () => {

    //load files

    fetch('/cloud_storage/src/Controllers/StorageController.php')
        .then(responce => responce.json())
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
            //показываем бар
            const activeElements = document.querySelectorAll('.item-file');
            activeElements.forEach(element => {
                element.addEventListener('click', function () {
                    activeElements.forEach(el => el.classList.remove('active-file'));
                    element.classList.add('active-file');
                    const barManipulation = document.querySelector('.bar-manipulation');
                    barManipulation.style.display = 'flex';
                    const nameFile = document.querySelector('.filename');
                    let fullFileName = element.getAttribute('data-fullname'); // Получаем полное имя файла
                    let shortenedFileName = shortenFileName(fullFileName); // Получаем сокращенное имя для отображения
                    nameFile.textContent = shortenedFileName; // Отображаем сокращенное имя в панели управления
                });
            });
            shareBtnClick();
            deleteFile();
            downloadFile();

            UploadFile();
            let upload = document.querySelector('.upload');
            let uploadFile = document.querySelector('#upload-file');

            upload.addEventListener('click', () => {
                uploadFile.click();
            });
        })
        .catch(error => {
            console.error('Ошибка: ', error);
        });
});
