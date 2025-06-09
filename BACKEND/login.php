<?php
session_start();
require_once "loginconnect.php";

$host = "localhost";
$db = "streaming";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    $_SESSION['error'] = "Błąd połączenia: " . $conn->connect_error;
    header("Location: loginSite.php");
    exit();
} else {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $haslo = $_POST['password'];
    } else {
        $_SESSION['error'] = "Proszę wypełnić wszystkie pola.";
        header("Location: loginSite.php");
        exit();
    }
}

$sql = "SELECT id_użytkownika, email, hasło_hash FROM Użytkownicy WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email); // ochrona przed sql injection
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($haslo, $user['hasło_hash'])) {
        $_SESSION['user_id'] = $user['id_użytkownika'];
        $_SESSION['email'] = $user['email'];
        setcookie("user_email", $user['email'], time() + (7 * 24 * 60 * 60), "/"); // Ciasteczko na 7 dni
        $_SESSION['success'] = "Zalogowano pomyślnie!";
        header("Location: home.php");
        exit();
    } else {
        $_SESSION['error'] = "Błędne hasło.";
        header("Location: loginSite.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Nie znaleziono użytkownika.";
    header("Location: loginSite.php");
    exit();
}

$stmt->close();
$conn->close();
?>