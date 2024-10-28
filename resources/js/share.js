document.addEventListener('DOMContentLoaded', () => {
    const uri = window.location;
    const uriLastLink = ((uri['href']).split('/'))[6];
    fetch('/App/storage/share/' + uriLastLink, {
        method: 'POST',
        body: uri['href']
    })
        .then(respoce => respoce.json())
        .then(data => {
            const nameFile = document.querySelector('.nameFile');
            nameFile.append(data);
        })
        .catch(error => {
            console.log('Произошла ошибка: ' + error);
        });

    document.querySelector('.downloadFile').addEventListener('click', (event) => {
        event.preventDefault();
        const nameFile = document.querySelector('.nameFile').innerHTML;
        fetch('/App/storage/download/', {
            method: 'POST',
            body: nameFile
        })
        .then(response => response.blob())
        .then(data => {
            const fileName = document.querySelector('.nameFile').innerHTML;
            
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
            console.log(error);
        })
    })
});
