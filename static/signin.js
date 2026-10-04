$(document).ready(function () {

  var $form = $("#signinForm");
  var $email = $("#email");
  var $password = $("#password");
  var $emailError = $("#emailError");
  var $passwordError = $("#passwordError");

  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function showError($input, $errorEl, message) {
    $errorEl.text(message);
    $input.addClass("invalid");
  }

  function clearError($input, $errorEl) {
    $errorEl.text("");
    $input.removeClass("invalid");
  }

  function validateEmail() {
    var value = $email.val().trim();

    if (value === "") {
      showError($email, $emailError, "Email is required.");
      return false;
    }

    if (!emailPattern.test(value)) {
      showError($email, $emailError, "Please enter a valid email address.");
      return false;
    }

    clearError($email, $emailError);
    return true;
  }

  function validatePassword() {
    var value = $password.val();

    if (value === "") {
      showError($password, $passwordError, "Password is required.");
      return false;
    }

    if (value.length < 8) {
      showError($password, $passwordError, "Password must be at least 8 characters.");
      return false;
    }

    if (value.length > 10) {
      showError($password, $passwordError, "Password must not exceed 10 characters.");
      return false;
    }

    clearError($password, $passwordError);
    return true;
  }

  // Real-time validation: check while typing and when leaving the field
  $email.on("input blur", validateEmail);
  $password.on("input blur", validatePassword);

  // Final validation on submit
  $form.on("submit", function (event) {
    event.preventDefault();

    var isEmailValid = validateEmail();
    var isPasswordValid = validatePassword();

    if (!isEmailValid) {
      $email.focus();
      return;
    }

    if (!isPasswordValid) {
      $password.focus();
      return;
    }

    // All fields valid — keep existing behavior
    window.location.href = "dashboard.php";
  });

});