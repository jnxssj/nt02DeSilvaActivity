<?php 
    require 'phpfile/functions.php';

    if (isset($_SESSION['user'])) {
        header('Location: dashboard.php');
        exit;
    }

    $email         = '';
    $emailError    = '';
    $passwordError = '';
    $loginError    = '';
    $message       = '';

    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'registered') {
            $message = 'Account created! You can now sign in.';
        }
        if ($_GET['status'] == 'loggedout') {
            $message = 'You have been signed out.';
        }
        if ($_GET['status'] == 'required') {
            $message = 'Please sign in to continue.';
        }
    }

    if (isset($_POST['login'])) {

        $email    = getPost('email');
        $password = getPost('password');

        if ($email == '') {
            $emailError = 'Email is required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = 'Please enter a valid email address.';
        }

        if ($password == '') {
            $passwordError = 'Password is required.';
        } elseif (strlen($password) < 8 || strlen($password) > 10) {
            $passwordError = 'Password must be 8 to 10 characters.';
        }

        if ($emailError == '' && $passwordError == '') {

            $user = findUser($email);

            if ($user != null && password_verify($password, $user['password_hash'])) {

                $_SESSION['user'] = [
                    'first_name' => $user['first_name'],
                    'last_name'  => $user['last_name'],
                    'email'      => $user['email']
                ];
                header('Location: dashboard.php');
                exit;
            } else {
                $loginError = 'Invalid email or password.';
            }
        }
    }

    $pageTitle = 'Sign In';
    $pageCss   = 'static/signin.css';
    $pageJs    = 'static/signin.js';
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

                <?php 
                    include 'phpfile/communityFrame.php'; 
                ?>

                <div class="form-side">
                    <p class="eyebrow">Sign In</p>
                    <h1>Welcome</h1>
                    <p class="subtitle">To keep connected with us, please login with your personal info.</p>

                    <form id="signinForm" method="post" action="signin.php" novalidate>

                        <?php if ($message != '') { ?>
                            <div class="form-alert success"><?php echo $message; ?></div>
                        <?php } ?>

                        <?php if ($loginError != '') { ?>
                            <div class="form-alert danger"><?php echo $loginError; ?></div>
                        <?php } ?>

                        <div class="field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="you@gmail.com" value="<?php echo htmlspecialchars($email); ?>" required>
                            <small class="error" id="emailError"><?php echo $emailError; ?></small>
                        </div>

                        <div class="field">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <small class="error" id="passwordError"><?php echo $passwordError; ?></small>
                            <div class="forgot-row"><a href="#">Forgot Password?</a></div>
                        </div>

                        <button type="submit" name="login" class="btn-primary">Sign In</button>

                        <p class="switch-text">Don't have an account? <a href="signup.php">Sign up</a></p>
                    </form>
                </div>

            </div>
        </main>

        <?php 
            include 'phpfile/scripts.php'; 
        ?>
    
    </body>
</html>
