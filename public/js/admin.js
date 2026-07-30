import '../css/admin.css';

const eye = document.querySelector('.feather-eye');
const eyeOff = document.querySelector('.feather-eye-off');
const password = document.querySelector('#password');

eye.addEventListener("click", () => {
  eye.style.display = "none";
  eyeOff.style.display = "block";
  password.type = "text";
});

eyeOff.addEventListener("click", () => {
  eyeOff.style.display = "none";
  eye.style.display = "block";
  password.type = "password";
});