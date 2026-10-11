<?php
    require 'phpfile/functions.php';

    if (isset($_SESSION['user'])) {
        header('Location: dashboard.php');
    } else {
        header('Location: signin.php');
    }
    exit;