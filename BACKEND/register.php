<?php
session_start();

require_once "loginconnect.php"; //połączenie z bazą danych
require_once "UserRegister.php"; //klasa do rejestracji użytkownika

//pobranie danych z formularza
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirmPassword = $_POST['confirmPassword'] ?? '';

//utworzenie obiektu rejestracji
$register = new UserRegister($conn);

//próba rejestracji
$result = $register->register($email, $username, $password, $confirmPassword);

//jeśli sukces, przekierowanie do logowania z komunikatem
if (isset($result['success'])) {
    $_SESSION['success'] = "Rejestracja zakończona sukcesem. Możesz się zalogować.";
    header("Location: loginSite.php");
    exit;
} else {
    //jeśli błąd, zapisanie błędu w sesji i powrót do formularza
    $_SESSION['error'] = $result['error'] ?? "Nieznany błąd.";
    header("Location: registerSite.php");
    exit;
}
?>
