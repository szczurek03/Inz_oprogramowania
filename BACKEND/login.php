<?php
session_start(); //start sesji
require_once "loginconnect.php"; //łączenie z bazą danych ($conn)
require_once "UserAuth.php"; //klasa autoryzacji użytkownika

//sprawdzenie czy pola email i hasło zostały przesłane
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    $_SESSION['error'] = "Proszę wypełnić wszystkie pola.";
    header("Location: loginSite.php"); //przekierowanie do strony logowania
    exit();
}

//utworzenie instancji klasy autoryzacji
$auth = new UserAuth($conn);
//wywołanie funkcji logowania
$result = $auth->login($_POST['email'], $_POST['password']);

//jeśli logowanie się powiodło
if (isset($result['success']) && $result['success']) {
    $_SESSION['user_id'] = $result['user_id']; //zapis id do sesji
    $_SESSION['email'] = $result['email']; //zapis emaila do sesji
    setcookie("user_email", $result['email'], time() + (7 * 24 * 60 * 60), "/"); //cookie na 7 dni
    $_SESSION['success'] = "Zalogowano pomyślnie!";
    header("Location: home.php"); //przekierowanie na stronę główną
    exit();
} else {
    //logowanie nie powiodło się, zapis błędu do sesji
    $_SESSION['error'] = $result['error'];
    header("Location: loginSite.php"); //powrót do strony logowania
    exit();
}
?>
