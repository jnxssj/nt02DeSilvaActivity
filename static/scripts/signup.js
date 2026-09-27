var panel1 = document.getElementById("panel1");
var panel2 = document.getElementById("panel2");
var panel3 = document.getElementById("panel3");

var dot1 = document.getElementById("stepDot1");
var dot2 = document.getElementById("stepDot2");
var dot3 = document.getElementById("stepDot3");

var step1Error = document.getElementById("step1Error");
var step2Error = document.getElementById("step2Error");
var step3Error = document.getElementById("step3Error");

function showPanel(panelToShow) {
  panel1.classList.remove("active");
  panel2.classList.remove("active");
  panel3.classList.remove("active");
  panelToShow.classList.add("active");
}

function setActiveDot(activeDot) {
  [dot1, dot2, dot3].forEach(function (dot) {
    dot.classList.remove("active");
  });
  activeDot.classList.add("active");
}

document.getElementById("toStep2").addEventListener("click", function () {
  var firstName = document.getElementById("firstName").value.trim();
  var lastName = document.getElementById("lastName").value.trim();
  var dob = document.getElementById("dob").value;
  var gender = document.getElementById("gender").value;
  var contact = document.getElementById("contact").value.trim();
  var houseNo = document.getElementById("houseNo").value.trim();
  var street = document.getElementById("street").value.trim();
  var purok = document.getElementById("purok").value;

  if (!firstName || !lastName || !dob || !gender || !contact || !houseNo || !street || !purok) {
    step1Error.textContent = "Please fill out all fields before continuing.";
    return;
  }

  step1Error.textContent = "";
  showPanel(panel2);
  setActiveDot(dot2);
  dot1.classList.add("done");
});

document.getElementById("toStep1").addEventListener("click", function () {
  step2Error.textContent = "";
  showPanel(panel1);
  setActiveDot(dot1);
});

document.getElementById("toStep3").addEventListener("click", function () {
  var email = document.getElementById("email").value.trim();
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("confirmPassword").value;

  if (!email || email.indexOf("@") === -1) {
    step2Error.textContent = "Please enter a valid email address.";
    return;
  }
  if (password.length < 8) {
    step2Error.textContent = "Password must be at least 8 characters.";
    return;
  }
  if (password !== confirmPassword) {
    step2Error.textContent = "Passwords do not match.";
    return;
  }

  step2Error.textContent = "";
  showPanel(panel3);
  setActiveDot(dot3);
  dot2.classList.add("done");
});

document.getElementById("toStep2b").addEventListener("click", function () {
  step3Error.textContent = "";
  showPanel(panel2);
  setActiveDot(dot2);
});

var idUpload = document.getElementById("idUpload");
var fileLabel = document.getElementById("fileLabel");

idUpload.addEventListener("change", function () {
  if (idUpload.files.length > 0) {
    fileLabel.innerHTML = "Selected file: <strong>" + idUpload.files[0].name + "</strong>";
  }
});

document.getElementById("signupForm").addEventListener("submit", function (event) {
  event.preventDefault();

  if (idUpload.files.length === 0) {
    step3Error.textContent = "Please upload a valid ID to finish signing up.";
    return;
  }

  step3Error.textContent = "";
  alert("Account created! (This is a demo — connect it to a real server to go live.)");
  window.location.href = "../templates/signin.html";
  
});