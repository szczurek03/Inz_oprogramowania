<?php
session_start();
require_once "loginconnect.php";
require_once "UserRegister.php";

$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

$register = new UserRegister($conn);
$result = $register->register($email, $username, $password, $confirmPassword);

if (isset($result['success'])) {
    $_SESSION['success'] = "Rejestracja zakończona sukcesem. Możesz się zalogować.";
    header("Location: loginSite.php");
    exit;
} else {
    $_SESSION['error'] = $result['error'] ?? "Nieznany błąd.";
    header("Location: registerSite.php");
    exit;
}
?>
