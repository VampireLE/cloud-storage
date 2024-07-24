const choiceLogin = document.querySelector('.img-login');
const choiceRegister = document.querySelector('.img-sign-up');
const signIn = document.querySelector('.sign-in');
const signUp = document.querySelector('.sign-up');

choiceLogin.addEventListener('click', function() {
    choiceRegister.classList.remove('active');
    choiceLogin.classList.add('active');
    signIn.style.display = 'flex';
    signUp.style.display = 'none';
});
choiceRegister.addEventListener('click', function() {
    choiceLogin.classList.remove('active');
    choiceRegister.classList.add('active');
    signIn.style.display = 'none';
    signUp.style.display = 'flex';
    
});

// const login = document.querySelector('.sign-in-btn');


// login.addEventListener('click', function (event) {
//     const inputLogin = document.querySelector('.Input-login').value;
//     const inputPassword = document.querySelector('.Input-password').value;

//     const inputData = {
//         'username': inputLogin,
//         'password': inputPassword
//     }
//     event.preventDefault();

//     fetch('/App/sign-in/', {
//         body: inputData,
//         method: 'POST',
//         headers: {
//             'Content-Type': 'application/json'
//         }
//     })
//     .then(responce => responce.json())
//     .then(data => {
//         console.log(data.json());
//     }).catch(error => {
//         console.log(error);
//     });
// });

// login.addEventListener('click', function (event) {
//     event.preventDefault();

//     fetch('/App/sign-in/')
//     .then(responce => responce.text())
//     .then(data => {
//         console.log(data.text());
//     }).catch(error => {
//         console.log(error);
//     });
// })

// register.addEventListener('click', function (event) {
//     event.preventDefault();

//     fetch('App/sign-up')
//     .then(responce => responce.text())
//     .then(data => {
//         console.log(data);
//     }).catch(error => {
//         console.log(error);
//     })
// })