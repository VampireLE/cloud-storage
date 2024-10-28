function shortenFileName(fileName, maxLength = 16) {
    const fileExtension = fileName.includes('.') ? fileName.slice(fileName.lastIndexOf('.')) : '';
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
        fetch('/App/storage/share/', {
            method: 'POST',
            body: fullFileName,
        })
        .then(response => response.json())
        .then(data => {
            let writeValue = document.createElement('input');
            writeValue.value = 'https://localhost/App/storage/share/' + data;
            document.body.appendChild(writeValue);
            writeValue.select();
            document.execCommand('copy');
            alert('В буфер обмена была скопирована ссылка на файл');
            writeValue.remove();
        })
        .catch(error => {
            console.log('Произошла ошибка: ' + error);
        });
    });
}

function deleteFile() {
    document.getElementById('deleteFile').addEventListener('click', (event) => {
        event.preventDefault();
        const fileName = document.querySelector('.active-file').getAttribute('data-fullname');
        fetch('/App/storage/delete/', {
            method: 'DELETE',
            body: JSON.stringify({ fileName: fileName }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.text())
        .then(data => {
            const barManipulation = document.querySelector('.bar-manipulation');
            barManipulation.style.display = 'none';
            const activeFile = document.querySelector('.active-file');
            activeFile.parentNode.removeChild(activeFile);
        })
        .catch(error => {
            console.error('Ошибка: ', error);
        });
    });
}

function downloadFile() {
    document.querySelector('.DownloadFile').addEventListener('click', (event) => {
        event.preventDefault();
        let fileName = document.querySelector('.active-file').getAttribute('data-fullname');
        fetch('/App/storage/download/', {
            method: 'POST',
            body: fileName
        })
        .then(response => response.blob())
        .then(data => {
            const url = window.URL.createObjectURL(data);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = fileName;
            document.body.appendChild(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.log('Ошибка: ', error);
        });
    });
}

function UploadFile() {
    let upload = document.querySelector('.upload');
    let uploadFile = document.querySelector('#upload-file');

    upload.addEventListener('click', () => {
        uploadFile.click();
    });

    const formUploadFile = document.getElementById('uploadFiles');
    formUploadFile.addEventListener('submit', (event) => {
        event.preventDefault();

        const file = formUploadFile.querySelector('[type="file"]').files[0];
        const formatData = new FormData();
        formatData.append('file', file);

        fetch('/App/storage/uploadFile/', {
            method: 'POST',
            body: formatData
        })
        .then(response => response.json())
        .then(data => {
            const fileList = document.getElementById('file-list');
            const elementFile = document.createElement('div');
            const span = document.createElement('p');
            const img = document.createElement('img');

            img.src = '/App/img/file.png';
            elementFile.classList.add('item-file');
            elementFile.setAttribute('data-fullname', file.name);
            span.textContent = shortenFileName(file.name);
            elementFile.appendChild(img);
            elementFile.appendChild(span);
            fileList.appendChild(elementFile);

            elementFile.addEventListener('click', () => {
                document.querySelectorAll('.item-file').forEach(el => el.classList.remove('active-file'));
                elementFile.classList.add('active-file');
                const barManipulation = document.querySelector('.bar-manipulation');
                barManipulation.style.display = 'flex';
                const nameFile = document.querySelector('.filename');
                nameFile.textContent = shortenFileName(file.name);
            });
        })
        .catch(error => {
            console.error('Ошибка: ', error);
        });
    });
}

document.addEventListener('DOMContentLoaded', (event) => {
    event.preventDefault();
    fetch('/App/storage/', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        const fileList = document.getElementById('file-list');
        fileList.innerHTML = '';

        const totalFiles = data.length;
        const itemsPerPage = 28;
        const totalPages = Math.ceil(totalFiles / itemsPerPage);
        let currentPage = 0;
        let paginationPages = document.querySelector('.pagination-pages');

        const paginationBefore = document.querySelector('.pagination-before');
        const paginationAfter = document.querySelector('.pagination-after');

        function updatePagination() {
            paginationPages.innerHTML = '';

            let startPage = Math.max(0, currentPage - 1);
            let endPage = Math.min(totalPages - 1, currentPage + 1);

            if (endPage - startPage < 2) {
                if (startPage === 0) {
                    endPage = Math.min(totalPages - 1, startPage + 2);
                } else {
                    startPage = Math.max(0, endPage - 2);
                }
            }

            for (let i = startPage; i <= endPage; i++) {
                let p = document.createElement('div');
                p.innerText = i + 1;
                if (i === currentPage) {
                    p.classList.add('active-page');
                }
                p.addEventListener('click', () => {
                    currentPage = i;
                    loadFiles();
                    updatePagination();
                });
                paginationPages.appendChild(p);
            }
        }

        function loadFiles() {
            fileList.innerHTML = '';
            const startIndex = currentPage * itemsPerPage;
            const endIndex = Math.min(startIndex + itemsPerPage, totalFiles);
            const ar = data.slice(startIndex, endIndex);
            
            ar.forEach(file => {
                const elementFile = document.createElement('div');
                const span = document.createElement('p');
                const img = document.createElement('img');
                img.src = '/App/img/file.png';
                elementFile.classList.add('item-file');
                elementFile.setAttribute('data-fullname', file);
                span.textContent = shortenFileName(file);
                elementFile.appendChild(img);
                elementFile.appendChild(span);
                fileList.appendChild(elementFile);
            });

            const activeElements = document.querySelectorAll('.item-file');
            activeElements.forEach(element => {
                element.addEventListener('click', () => {
                    activeElements.forEach(el => el.classList.remove('active-file'));
                    element.classList.add('active-file');
                    const barManipulation = document.querySelector('.bar-manipulation');
                    barManipulation.style.display = 'flex';
                    const nameFile = document.querySelector('.filename');
                    let fullFileName = element.getAttribute('data-fullname');
                    let shortenedFileName = shortenFileName(fullFileName);
                    nameFile.textContent = shortenedFileName;
                });
            });
        }

        paginationBefore.addEventListener('click', () => {
            if (currentPage > 0) {
                currentPage--;
                loadFiles();
                updatePagination();
            }
        });

        paginationAfter.addEventListener('click', () => {
            if (currentPage < totalPages - 1) {
                currentPage++;
                loadFiles();
                updatePagination();
            }
        });

        if (totalFiles <= itemsPerPage) {
            document.querySelector('.pagination').style.display = 'none';
            document.querySelector('.pagination-before').style.display = 'none';
            document.querySelector('.pagination-after').style.display = 'none';
        } else {
            document.querySelector('.pagination').style.display = 'flex';
            document.querySelector('.pagination-before').style.display = 'block';
            document.querySelector('.pagination-after').style.display = 'block';
        }

        updatePagination();
        loadFiles();

        document.addEventListener('click', (event) => {
            const fileListElement = document.getElementById('file-list');
            const barManipulation = document.querySelector('.bar-manipulation');
            const isClickInsideBarManipulation = fileListElement.contains(event.target);
            const isClickInsideFileList = barManipulation.contains(event.target);
            
            if (!isClickInsideBarManipulation && !isClickInsideFileList) {
                barManipulation.style.display = 'none';
                const activeElements = document.querySelectorAll('.item-file');
                activeElements.forEach(el => el.classList.remove('active-file'));
            }
        });

        shareBtnClick();
        deleteFile();
        downloadFile();
        UploadFile();
    })
    .catch(error => {
        console.error('Ошибка: ', error);
    });
});

