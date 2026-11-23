<?php
require_once('../private/initialize.php');

// Remove the login data, end the session, go back to login
unset($_SESSION['admin_id']);
unset($_SESSION['username']);
session_destroy();

redirect_to(url_for('/login.php'));
