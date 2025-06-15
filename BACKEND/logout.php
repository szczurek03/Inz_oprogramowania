<?php
session_start(); //rozpoczęcie sesji
require_once 'logout_functions.php'; //dołączenie funkcji wylogowującej

logoutUser(); //wywołanie funkcji wylogowania

//ustawienie nagłówków zapobiegających buforowaniu strony
header('Cache-Control: no-cache, no-store, must-revalidate');

//przekierowanie do strony logowania
header('Location: loginSite.php');
exit;
?>
