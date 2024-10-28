const btnCreate = document.querySelector('.btn-create');
const popupContainer = document.querySelector('.popup-container');
const closeBtn = document.querySelector('.close-btn');
const createUser = document.querySelector('.create-user');
const popup = document.querySelector('.popup');

const editCloseBtn = document.querySelector('.edit-close-btn');
const editPopupContainer = document.querySelector('.edit-popup-container');
const editPopup = document.querySelector('.edit-popup');



editPopupContainer.addEventListener('click', (event) => {
    if (event.target == editPopupContainer) {
        editPopupContainer.style.display = 'none';
    }
});

btnCreate.addEventListener('click', (event) => {
    event.preventDefault;

    popupContainer.style.display = 'flex';
});

closeBtn.addEventListener('click', () => {
    popupContainer.style.display = 'none';
});

popupContainer.addEventListener('click', (event) => {
    if (event.target === popupContainer) {
        popupContainer.style.display = 'none';
    }
});


document.getElementById('create-user-form').addEventListener('submit', (event) => {
    event.preventDefault();

    let data = [];
    const formData = new FormData(event.target);
    const login = formData.get('sign-up[login]');
    const password = formData.get('sign-up[password]');
    const confirmPassword = formData.get('sign-up[confirm_password]');
    const role = formData.get('role');
    data.push({
        'login': login,
        'password': password,
        'confirm_password': confirmPassword,
        'role': role
    });
    
    fetch('/App/admin-panel/create/', {
        method: 'POST',
        body: JSON.stringify(data)
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch(error => {
        console.log(error);
    });
});


document.addEventListener('DOMContentLoaded', () => {
    fetch('/App/admin-panel/', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        const ar = data;
        const showUsersTbody = document.querySelector('.show-users');
        
        ar.forEach(element => {
            
            const tr = document.createElement('tr');
            const form = document.createElement('form');
            
            const tdLogin = document.createElement('td');
            tdLogin.textContent = element['login'];
            
            tr.appendChild(tdLogin);
            
            const tdPassword = document.createElement('td');
            tdPassword.textContent = element['password'];
            tr.appendChild(tdPassword);

            
            const tdRole = document.createElement('td');
            tdRole.textContent = element['isAdmin'] === 0 ? 'User' : 'Admin';
            tr.appendChild(tdRole);

            const tdTools = document.createElement('td');
            const editButton = document.createElement('button');
            const deleteButton = document.createElement('button');
            const editSpan = document.createElement('span');
            const deleteSpan = document.createElement('span');

            editSpan.textContent = 'Edit';
            deleteSpan.textContent = 'Delete';

            editSpan.classList.add('span-edit');
            deleteSpan.classList.add('span-delete');

            editButton.classList.add('btn-edit');
            deleteButton.classList.add('btn-delete');

            editButton.appendChild(editSpan);
            deleteButton.appendChild(deleteSpan);

            form.classList.add('form-tools');

            form.appendChild(editButton);
            form.appendChild(deleteButton);

            tdTools.appendChild(form);

            tr.appendChild(tdTools);

            showUsersTbody.appendChild(tr);
            
        });

        const form = document.querySelectorAll('.form-tools button');
        form.forEach(button => {
            if (button.innerText === 'Edit') {
                button.addEventListener('click', (event) => {
                    event.preventDefault();

                    document.querySelector('.edit-popup-container').style.display = 'flex';

                    const editPopup = document.querySelector('.edit-popup');
                    editPopup.innerHTML = '';

                    const row = button.closest('tr');
                    const username = row.cells[0].innerText;
                    const password = row.cells[1].innerText;
                    const role = row.cells[2].innerText;

                    const editInputUsername = document.createElement('input');
                    const editInputPassword = document.createElement('input');
                    const editInputRole = document.createElement('input');
                    const editBtn = document.createElement('button');
                    const editCloseBtn = document.createElement('div');

                    editInputUsername.classList.add('edit-popup-input');
                    editInputPassword.classList.add('edit-popup-input');
                    editInputRole.classList.add('edit-popup-input');
                    editBtn.classList.add('edit-popup-btn');
                    editCloseBtn.classList.add('edit-close-btn');

                    editInputUsername.value = username;
                    editInputPassword.value = password;
                    editInputRole.value = role;
                    editBtn.innerText = 'Submit';

                    editInputUsername.required = true;
                    editInputPassword.required = true;
                    editInputRole.required = true;

                    editPopup.appendChild(editInputUsername);
                    editPopup.appendChild(editInputPassword);
                    editPopup.appendChild(editInputRole);
                    editPopup.appendChild(editBtn);
                    editPopup.appendChild(editCloseBtn);

                    editCloseBtn.addEventListener('click', () => {
                        document.querySelector('.edit-popup-container').style.display = 'none';
                    });
                    
                    
                });
            } else if (button.innerText === 'Delete') {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
    
                    const row = button.closest('tr');
                    const username = row.cells[0].innerText;
                    const password = row.cells[1].innerText;
                    const role = row.cells[2].innerText;
    
                    let data = [];
    
                    data.push({
                        'login': username,
                        'password': password,
                        'role': role
                    });
                    
                    
                    fetch('/App/admin-panel/delete/', {
                        method: 'DELETE',
                        body: JSON.stringify(data)
                        
                    })
                    .then(response => response.text())
                    .then(data => {
                        console.log(data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
                });
            }
            
        });
    })
    .catch(error => {
        console.log(error);
    });

});