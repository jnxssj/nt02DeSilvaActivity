<?php
    require 'phpfile/functions.php';

    if (isset($_SESSION['user'])) {
        header('Location: dashboard.php');
        exit;
    }

    $firstName = '';
    $lastName  = '';
    $dob       = '';
    $gender    = '';
    $contact   = '';
    $houseNo   = '';
    $street    = '';
    $purok     = '';
    $email     = '';

    $firstNameError = '';
    $lastNameError  = '';
    $dobError       = '';
    $genderError    = '';
    $contactError   = '';
    $houseNoError   = '';
    $streetError    = '';
    $purokError     = '';
    $emailError     = '';
    $passwordError  = '';
    $confirmError   = '';
    $idError        = '';
    $formError      = '';

    if (isset($_POST['register'])) {

        $firstName = getPost('firstName');
        $lastName  = getPost('lastName');
        $dob       = getPost('dob');
        $gender    = getPost('gender');
        $contact   = getPost('contact');
        $houseNo   = getPost('houseNo');
        $street    = getPost('street');
        $purok     = getPost('purok');
        $email     = getPost('email');
        $password  = getPost('password');
        $confirm   = getPost('confirmPassword');

        if ($firstName == '') {
            $firstNameError = 'First name is required.';
        } elseif (!preg_match("/^[\p{L} -]{2,50}$/u", $firstName)) {
            $firstNameError = 'First name must be letters only (2-50 characters).';
        }

        if ($lastName == '') {
        $lastNameError = 'Last name is required.';
        } elseif (!preg_match("/^[\p{L} -]{2,50}$/u", $lastName)) {
            $lastNameError = 'Last name must be letters only (2-50 characters).';
        }

        if ($dob == '') {
            $dobError = 'Birthdate is required.';
        } elseif (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $dob)) {
            $dobError = 'Enter a valid birthdate.';
        } elseif ($dob > date('Y-m-d')) {
            $dobError = 'Birthdate cannot be in the future.';
        }

        if ($gender == '') {
            $genderError = 'Gender is required.';
        } elseif (!in_array($gender, ['female', 'male', 'prefer-not-to-say'])) {
            $genderError = 'Please choose a valid gender.';
        }

        if ($contact == '') {
            $contactError = 'Contact number is required.';
        } elseif (!preg_match('/^09[0-9]{9}$/', $contact)) {
            $contactError = 'Use an 11-digit mobile number starting with 09.';
        }

        if ($houseNo == '') {
            $houseNoError = 'House number is required.';
        } elseif (!preg_match('/^[0-9]{1,6}$/', $houseNo)) {
            $houseNoError = 'House number must contain numbers only.';
        }

        if ($street == '') {
            $streetError = 'Street is required.';
        } elseif (!preg_match('/^[A-Za-z0-9 .,#-]{2,60}$/', $street)) {
            $streetError = 'Street contains invalid characters.';
        }

        if ($purok == '') {
            $purokError = 'Purok is required.';
        } elseif (!in_array($purok, ['1', '2', '3', '4', '5'])) {
            $purokError = 'Please choose a valid purok.';
        }

        if ($email == '') {
            $emailError = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Please enter a valid email address.';
        } elseif (findUser($email) != null) {
            $emailError = 'An account with this email already exists.';
        }

        if ($password == '') {
            $passwordError = 'Password is required.';
        } elseif (strlen($password) < 8) {
            $passwordError = 'Password must be at least 8 characters.';
        } elseif (strlen($password) > 10) {
            $passwordError = 'Password must not exceed 10 characters.';
        } elseif (!preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
            $passwordError = 'Password needs at least one letter and one number.';
        }

        if ($confirm == '') {
            $confirmError = 'Please confirm your password.';
        } elseif ($confirm != $password) {
            $confirmError = 'Passwords do not match.';
        }

        if (!isset($_FILES['idUpload']) || $_FILES['idUpload']['error'] == UPLOAD_ERR_NO_FILE) {
            $idError = 'Please upload a valid ID.';
        } elseif ($_FILES['idUpload']['error'] != UPLOAD_ERR_OK) {
            $idError = 'Upload failed. Please try again.';
        } elseif ($_FILES['idUpload']['size'] > 5 * 1024 * 1024) {
            $idError = 'File is too large (5MB maximum).';
        } else {
            $ext = strtolower(pathinfo($_FILES['idUpload']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['png', 'jpg', 'jpeg', 'pdf'])) {
                $idError = 'Only PNG, JPG or PDF files are allowed.';
            }
        }

        $allErrors = $firstNameError . $lastNameError . $dobError . $genderError . $contactError .
                 $houseNoError . $streetError . $purokError . $emailError . $passwordError .
                 $confirmError . $idError;

        if ($allErrors == '') {

            $idFile = time() . '.' . $ext;
            move_uploaded_file($_FILES['idUpload']['tmp_name'], 'uploads/' . $idFile);

            
            $users = loadUsers();
            $users[] = [
                'first_name'    => $firstName,
                'last_name'     => $lastName,
                'dob'           => $dob,
                'gender'        => $gender,
                'contact'       => $contact,
                'house_no'      => $houseNo,
                'street'        => $street,
                'purok'         => $purok,
                'email'         => strtolower($email),
                'password_hash' => password_hash($password, PASSWORD_DEFAULT),  
                'id_file'       => $idFile
            ];
            saveUsers($users);

            header('Location: signin.php?status=registered');
            exit;
        }
    }

    $startStep = 1;
    if ($idError != '') {
        $startStep = 3;
    }
    if ($emailError != '' || $passwordError != '' || $confirmError != '') {
        $startStep = 2;
    }
    if ($firstNameError != '' || $lastNameError != '' || $dobError != '' || $genderError != '' ||
        $contactError != '' || $houseNoError != '' || $streetError != '' || $purokError != '') {
        $startStep = 1;
    }

    $pageTitle = 'Sign Up';
    $pageCss   = 'static/signup.css';
    $pageJs    = 'static/signup.js';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            include 'phpfile/head.php'; 
        ?>
    </head>

    <body>

        <main class="page">
            <div class="card">

                <div class="form-side">
                    <p class="eyebrow">Sign Up</p>
                    <h1>Create Account</h1>

                    <!-- === Step indicator === -->
                    <ol class="steps">
                        <li class="step <?php if ($startStep == 1) { echo 'active'; } if ($startStep > 1) { echo 'done'; } ?>" id="stepDot1"><span>1</span></li>
                        <li class="line"></li>
                        <li class="step <?php if ($startStep == 2) { echo 'active'; } if ($startStep > 2) { echo 'done'; } ?>" id="stepDot2"><span>2</span></li>
                        <li class="line"></li>
                        <li class="step <?php if ($startStep == 3) { echo 'active'; } ?>" id="stepDot3"><span>3</span></li>
                    </ol>

                    <form id="signupForm" method="post" action="signup.php" enctype="multipart/form-data" novalidate>

                        <!-- === STEP 1: Personal Information === -->
                        <section class="step-panel <?php if ($startStep == 1) { echo 'active'; } ?>" id="panel1">
                            <div class="field-row">
                                <div class="field">
                                    <label for="firstName">First Name</label>
                                    <input type="text" id="firstName" name="firstName" placeholder="Juan" maxlength="50" value="<?php echo htmlspecialchars($firstName); ?>" required>
                                    <small class="error" id="firstNameError"><?php echo $firstNameError; ?></small>
                                </div>
                                <div class="field">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" id="lastName" name="lastName" placeholder="Dela Cruz" maxlength="50" value="<?php echo htmlspecialchars($lastName); ?>" required>
                                    <small class="error" id="lastNameError"><?php echo $lastNameError; ?></small>
                                </div>
                            </div>

                            <div class="field">
                                <label for="dob">Date of Birth</label>
                                <input type="date" id="dob" name="dob" max="<?php echo date('Y-m-d'); ?>" value="<?php echo htmlspecialchars($dob); ?>" required>
                                <small class="error" id="dobError"><?php echo $dobError; ?></small>
                            </div>

                            <div class="field">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" required>
                                    <option value="" disabled <?php if ($gender == '') { echo 'selected'; } ?>>Select gender...</option>
                                    <option value="female" <?php if ($gender == 'female') { echo 'selected'; } ?>>Female</option>
                                    <option value="male" <?php if ($gender == 'male') { echo 'selected'; } ?>>Male</option>
                                    <option value="prefer-not-to-say" <?php if ($gender == 'prefer-not-to-say') { echo 'selected'; } ?>>Prefer not to say</option>
                                </select>
                                <small class="error" id="genderError"><?php echo $genderError; ?></small>
                            </div>

                            <div class="field">
                                <label for="contact">Contact Number</label>
                                <input type="tel" id="contact" name="contact" placeholder="09xxxxxxxxx" maxlength="11" inputmode="numeric" value="<?php echo htmlspecialchars($contact); ?>" required>
                                <small class="error" id="contactError"><?php echo $contactError; ?></small>
                            </div>

                            <div class="field-row">
                                <div class="field">
                                    <label for="houseNo">House No.</label>
                                    <input type="text" id="houseNo" name="houseNo" placeholder="e.g. 1234" maxlength="6" inputmode="numeric" value="<?php echo htmlspecialchars($houseNo); ?>" required>
                                    <small class="error" id="houseNoError"><?php echo $houseNoError; ?></small>
                                </div>
                                <div class="field">
                                    <label for="street">Street</label>
                                    <input type="text" id="street" name="street" placeholder="Street Name" maxlength="60" value="<?php echo htmlspecialchars($street); ?>" required>
                                    <small class="error" id="streetError"><?php echo $streetError; ?></small>
                                </div>
                            </div>

                            <div class="field">
                                <label for="purok">Purok</label>
                                <select id="purok" name="purok" required>
                                    <option value="" disabled <?php if ($purok == '') { echo 'selected'; } ?>>Select Purok</option>
                                    <option value="1" <?php if ($purok == '1') { echo 'selected'; } ?>>Purok 1</option>
                                    <option value="2" <?php if ($purok == '2') { echo 'selected'; } ?>>Purok 2</option>
                                    <option value="3" <?php if ($purok == '3') { echo 'selected'; } ?>>Purok 3</option>
                                    <option value="4" <?php if ($purok == '4') { echo 'selected'; } ?>>Purok 4</option>
                                    <option value="5" <?php if ($purok == '5') { echo 'selected'; } ?>>Purok 5</option>
                                </select>
                                <small class="error" id="purokError"><?php echo $purokError; ?></small>
                            </div>

                            <small class="error" id="step1Error"></small>
                            <button type="button" class="btn-primary" id="toStep2">Next</button>
                        </section>

                        <!-- STEP 2: Email & Password -->
                        <section class="step-panel <?php if ($startStep == 2) { echo 'active'; } ?>" id="panel2">
                            <div class="field">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" placeholder="you@gmail.com" value="<?php echo htmlspecialchars($email); ?>" required>
                                <small class="error" id="emailError"><?php echo $emailError; ?></small>
                            </div>
                            <div class="field">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="8-10 characters, letters and numbers" minlength="8" maxlength="10" required>
                                <small class="error" id="passwordError"><?php echo $passwordError; ?></small>
                            </div>
                            <div class="field">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Re-enter password" minlength="8" maxlength="10" required>
                                <small class="error" id="confirmPasswordError"><?php echo $confirmError; ?></small>
                            </div>

                            <small class="error" id="step2Error"></small>
                            <div class="btn-row">
                                <button type="button" class="btn-secondary" id="toStep1">Back</button>
                                <button type="button" class="btn-primary" id="toStep3">Verify</button>
                            </div>
                        </section>

                        <!-- STEP 3: ID Verification -->
                        <section class="step-panel <?php if ($startStep == 3) { echo 'active'; } ?>" id="panel3">
                            <div class="upload-box">
                                <div class="upload-icon">🪪</div>
                                <p class="upload-title">Upload Valid ID</p>
                                <p class="upload-subtitle">Upload your government-issued ID for verification</p>
                                <label class="dropzone" for="idUpload">
                                    <span id="fileLabel">Drag &amp; drop or click to upload<br><small>PNG, JPG, PDF up to 5MB</small></span>
                                </label>
                                <input type="file" id="idUpload" name="idUpload" accept=".png,.jpg,.jpeg,.pdf" hidden required>
                            </div>

                            <small class="error" id="step3Error"><?php echo $idError; ?></small>
                            <div class="btn-row">
                                <button type="button" class="btn-secondary" id="toStep2b">Back</button>
                                <button type="submit" name="register" class="btn-primary">Sign Up</button>
                            </div>
                        </section>

                    </form>

                    <p class="switch-text">Already have an account? <a href="signin.php">Sign in</a></p>
                </div>

                <?php 
                    include 'phpfile/communityFrame.php';
                ?>

            </div>
        </main>

        <?php 
            include 'phpfile/scripts.php';
        ?>
    </body>
</html>
