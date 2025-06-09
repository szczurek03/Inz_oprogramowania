<?php
session_start();

unset($_SESSION['user_id']);
unset($_SESSION['nazwa_użytkownika']);
unset($_SESSION['email']);

session_destroy();

if (isset($_COOKIE['user_email'])) {
    setcookie('user_email', '', time() - 3600, '/'); 
}

header('Cache-Control: no-cache, no-store, must-revalidate');

header('Location: loginSite.php');
exit;
?>