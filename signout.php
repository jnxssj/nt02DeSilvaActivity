<?php
require 'phpfile/functions.php';

session_destroy();   // forget the logged-in user
header('Location: signin.php?status=loggedout');
exit;
