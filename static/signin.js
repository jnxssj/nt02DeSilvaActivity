var form = document.getElementById("signinForm");
var emailInput = document.getElementById("email");
var passwordInput = document.getElementById("password");
var emailError = document.getElementById("emailError");
var passwordError = document.getElementById("passwordError");

form.addEventListener("submit", function (event) {
  event.preventDefault();

  var isValid = true;

  emailError.textContent = "";
  passwordError.textContent = "";
  emailInput.classList.remove("invalid");
  passwordInput.classList.remove("invalid");

  var emailValue = emailInput.value.trim();
  if (emailValue === "") {
    emailError.textContent = "Please enter your email.";
    emailInput.classList.add("invalid");
    isValid = false;
  } else if (emailValue.indexOf("@") === -1 || emailValue.indexOf(".") === -1) {
    emailError.textContent = "Please enter a valid email address.";
    emailInput.classList.add("invalid");
    isValid = false;
  }

  var passwordValue = passwordInput.value;
  if (passwordValue === "") {
    passwordError.textContent = "Please enter your password.";
    passwordInput.classList.add("invalid");
    isValid = false;
  } else if (passwordValue.length < 8) {
    passwordError.textContent = "Password must be at least 8 characters.";
    passwordInput.classList.add("invalid");
    isValid = false;
  }

   if (isValid) { window.location.href = "index.html"; }
   
});