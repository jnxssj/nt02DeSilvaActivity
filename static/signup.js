$(document).ready(function () {

  var $panel1 = $("#panel1");
  var $panel2 = $("#panel2");
  var $panel3 = $("#panel3");

  var $dot1 = $("#stepDot1");
  var $dot2 = $("#stepDot2");
  var $dot3 = $("#stepDot3");

  var $step1Error = $("#step1Error");
  var $step2Error = $("#step2Error");
  var $step3Error = $("#step3Error");

  function showPanel($panelToShow) {
    $panel1.removeClass("active");
    $panel2.removeClass("active");
    $panel3.removeClass("active");
    $panelToShow.addClass("active");
  }

  function setActiveDot($activeDot) {
    $dot1.removeClass("active");
    $dot2.removeClass("active");
    $dot3.removeClass("active");
    $activeDot.addClass("active");
  }

  var $firstName = $("#firstName");
  var $lastName = $("#lastName");
  var $dob = $("#dob");
  var $gender = $("#gender");
  var $contact = $("#contact");
  var $houseNo = $("#houseNo");
  var $email = $("#email");
  var $password = $("#password");
  var $confirmPassword = $("#confirmPassword");

  var $firstNameError = $("#firstNameError");
  var $lastNameError = $("#lastNameError");
  var $dobError = $("#dobError");
  var $genderError = $("#genderError");
  var $contactError = $("#contactError");
  var $houseNoError = $("#houseNoError");
  var $emailError = $("#emailError");
  var $passwordError = $("#passwordError");
  var $confirmPasswordError = $("#confirmPasswordError");

  var namePattern = /^[A-Za-z\s-]+$/;
  var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function showError($input, $errorEl, message) {
    $errorEl.text(message);
    $input.addClass("invalid");
  }

  function clearError($input, $errorEl) {
    $errorEl.text("");
    $input.removeClass("invalid");
  }

  function validateFirstName() {
    var value = $firstName.val().trim();
    if (value === "") {
      showError($firstName, $firstNameError, "First name is required.");
      return false;
    }
    if (!namePattern.test(value)) {
      showError($firstName, $firstNameError, "First name must not contain numbers.");
      return false;
    }
    clearError($firstName, $firstNameError);
    return true;
  }

  function validateLastName() {
    var value = $lastName.val().trim();
    if (value === "") {
      showError($lastName, $lastNameError, "Last name is required.");
      return false;
    }
    if (!namePattern.test(value)) {
      showError($lastName, $lastNameError, "Last name must not contain numbers.");
      return false;
    }
    clearError($lastName, $lastNameError);
    return true;
  }

  function validateDob() {
    var value = $dob.val();
    if (value === "") {
      showError($dob, $dobError, "Birthdate is required.");
      return false;
    }
    clearError($dob, $dobError);
    return true;
  }

  function validateGender() {
    var value = $gender.val();
    if (!value) {
      showError($gender, $genderError, "Gender is required.");
      return false;
    }
    clearError($gender, $genderError);
    return true;
  }

  function validateContact() {
    var value = $contact.val().trim();
    if (value === "") {
      showError($contact, $contactError, "Contact number is required.");
      return false;
    }
    if (!/^\d+$/.test(value)) {
      showError($contact, $contactError, "Contact number must contain numbers only.");
      return false;
    }
    clearError($contact, $contactError);
    return true;
  }

  function validateHouseNo() {
    var value = $houseNo.val().trim();
    if (value === "") {
      showError($houseNo, $houseNoError, "House number is required.");
      return false;
    }
    if (!/^\d+$/.test(value)) {
      showError($houseNo, $houseNoError, "House number must contain numbers only.");
      return false;
    }
    clearError($houseNo, $houseNoError);
    return true;
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

  function validateConfirmPassword() {
    var value = $confirmPassword.val();
    if (value === "") {
      showError($confirmPassword, $confirmPasswordError, "Please confirm your password.");
      return false;
    }
    if (value !== $password.val()) {
      showError($confirmPassword, $confirmPasswordError, "Passwords do not match.");
      return false;
    }
    clearError($confirmPassword, $confirmPasswordError);
    return true;
  }

  // ---------- Real-time validation bindings ----------
  $firstName.on("input blur", validateFirstName);
  $lastName.on("input blur", validateLastName);
  $dob.on("change blur", validateDob);
  $gender.on("change blur", validateGender);
  $email.on("input blur", validateEmail);
  $password.on("input blur", function () {
    validatePassword();
    // Re-check confirm password whenever the original password changes
    if ($confirmPassword.val() !== "") {
      validateConfirmPassword();
    }
  });
  $confirmPassword.on("input blur", validateConfirmPassword);

  // Contact Number: strip non-digit characters as the user types, then validate
  $contact.on("input blur", function () {
    var filtered = $contact.val().replace(/[^0-9]/g, "");
    if (filtered !== $contact.val()) {
      $contact.val(filtered);
    }
    validateContact();
  });

  // House No.: strip non-digit characters as the user types, then validate
  $houseNo.on("input blur", function () {
    var filtered = $houseNo.val().replace(/[^0-9]/g, "");
    if (filtered !== $houseNo.val()) {
      $houseNo.val(filtered);
    }
    validateHouseNo();
  });

  // ---------- Step 1 -> Step 2 ----------
  $("#toStep2").on("click", function () {
    var street = $("#street").val().trim();
    var purok = $("#purok").val();

    var isValid = validateFirstName();
    isValid = validateLastName() && isValid;
    isValid = validateDob() && isValid;
    isValid = validateGender() && isValid;
    isValid = validateContact() && isValid;
    isValid = validateHouseNo() && isValid;

    if (!street || !purok) {
      isValid = false;
    }

    if (!isValid) {
      $step1Error.text("Please fix the highlighted fields before continuing.");
      return;
    }

    $step1Error.text("");
    showPanel($panel2);
    setActiveDot($dot2);
    $dot1.addClass("done");
  });

  $("#toStep1").on("click", function () {
    $step2Error.text("");
    showPanel($panel1);
    setActiveDot($dot1);
  });

  // ---------- Step 2 -> Step 3 ----------
  $("#toStep3").on("click", function () {
    var isValid = validateEmail();
    isValid = validatePassword() && isValid;
    isValid = validateConfirmPassword() && isValid;

    if (!isValid) {
      $step2Error.text("Please fix the highlighted fields before continuing.");
      return;
    }

    $step2Error.text("");
    showPanel($panel3);
    setActiveDot($dot3);
    $dot2.addClass("done");
  });

  $("#toStep2b").on("click", function () {
    $step3Error.text("");
    showPanel($panel2);
    setActiveDot($dot2);
  });

  // ---------- ID upload preview (unchanged behavior) ----------
  var $idUpload = $("#idUpload");
  var $fileLabel = $("#fileLabel");

  $idUpload.on("change", function () {
    if (this.files.length > 0) {
      $fileLabel.html("Selected file: <strong>" + this.files[0].name + "</strong>");
    }
  });

  // ---------- Final submit: re-validate everything ----------
  $("#signupForm").on("submit", function (event) {
    event.preventDefault();

    var isValid = validateFirstName();
    isValid = validateLastName() && isValid;
    isValid = validateDob() && isValid;
    isValid = validateGender() && isValid;
    isValid = validateContact() && isValid;
    isValid = validateHouseNo() && isValid;
    isValid = validateEmail() && isValid;
    isValid = validatePassword() && isValid;
    isValid = validateConfirmPassword() && isValid;

    if ($idUpload[0].files.length === 0) {
      $step3Error.text("Please upload a valid ID to finish signing up.");
      isValid = false;
    } else {
      $step3Error.text("");
    }

    if (!isValid) {
      // Send the user back to whichever step has the problem
      if (!validateFirstName() || !validateLastName() || !validateDob() || !validateGender() || !validateContact() || !validateHouseNo()) {
        showPanel($panel1);
        setActiveDot($dot1);
        $step1Error.text("Please fix the highlighted fields before continuing.");
      } else if (!validateEmail() || !validatePassword() || !validateConfirmPassword()) {
        showPanel($panel2);
        setActiveDot($dot2);
        $step2Error.text("Please fix the highlighted fields before continuing.");
      }
      return;
    }

    alert("Account created! (This is a demo — connect it to a real server to go live.)");
    window.location.href = "signin.html";
  });

});