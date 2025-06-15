<?php
//funkcja wylogowująca użytkownika
function logoutUser() {
    //usunięcie danych sesji
    unset($_SESSION['user_id']);
    unset($_SESSION['nazwa_użytkownika']);
    unset($_SESSION['email']);

    //zniszczenie całej sesji
    session_destroy();

    //usunięcie ciasteczka z e-mailem jeśli istnieje
    if (isset($_COOKIE['user_email'])) {
        setcookie('user_email', '', time() - 3600, '/'); //ustawienie czasu ważności w przeszłości
    }
}
?>
