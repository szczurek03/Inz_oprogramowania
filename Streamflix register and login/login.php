<?php
session_start();
require_once "loginconnect.php";

$host = "localhost";
$db = "streaming";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}
else{
    $email = $_POST['email'];
    $haslo = $_POST['password'];

}


$sql = "SELECT * FROM Użytkownicy WHERE email = '$email'";
$result = $conn->query($sql);

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($haslo, $user['hasło_hash'])) {
        $_SESSION['user_id'] = $user['id_użytkownika'];
        $_SESSION['email'] = $user['email'];
        echo "Zalogowano pomyślnie!";
    } else {
        echo "Błędne hasło.";
    }
} else {
    echo "Nie znaleziono użytkownika.";
}

$conn->close();
?>