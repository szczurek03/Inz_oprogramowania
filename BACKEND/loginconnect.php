<?php
$host = "localhost"; //adres serwera bazy danych
$db = "streaming";  //nazwa bazy danych
$user = "root"; //nazwa użytkownika bazy danych
$pass = ""; //hasło użytkownika (domyślnie puste w XAMPP)

//nawiązanie połączenia z bazą danych
$conn = new mysqli($host, $user, $pass, $db);

//sprawdzenie, czy połączenie się powiodło
if($conn->connect_errno != 0){
    echo "Error:" . $conn->connect_errno; //wyświetlenie kodu błędu
    exit; //zatrzymanie dalszego działania skryptu
}
?>

