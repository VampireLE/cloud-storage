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