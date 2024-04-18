document.addEventListener('DOMContentLoaded', function () {
    fetch('/cloud_storage/src/Controllers/StorageController.php', {
        method: 'POST',
        credentials: 'include'
    })
        .then(response => response.json())
        .then(data => {
            // console.log(data);
            const fileList = document.getElementById('file-list');
            const barManipulation = document.querySelector('.bar-manipulation');
            fileList.innerHTML = '';
            data.forEach(file => {

                const elementFile = document.createElement('div');
                const span = document.createElement('span');
                const img = document.createElement('img');

                img.src = './img-folder.png';

                elementFile.classList.add('item-file');
                span.textContent = file;

                elementFile.appendChild(img);
                elementFile.appendChild(span);
                fileList.appendChild(elementFile);
            })
                .catch(error => {
                    console.error('Error fetching data: ', error);
                });
        });
})