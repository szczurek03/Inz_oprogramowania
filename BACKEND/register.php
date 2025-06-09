<?php
session_start();
require_once "loginconnect.php";

function validateUsername($username) {
    return preg_match('/^[a-zA-Z0-9._]{3,}$/', $username);
}
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}


// $countryMap = [
//     'pl' => 1,
//     'us' => 2,
//     'de' => 3,
//     'fr' => 4,
//     'gb' => 5,
// ];

if (isset($_POST['email'])) {
    $email = trim($_POST['email']);
} else {
    $email = '';
}

if (isset($_POST['password'])) {
    $password = $_POST['password'];
} else {
    $password = '';
}

if (isset($_POST['confirmPassword'])) {
    $confirmPassword = $_POST['confirmPassword'];
} else {
    $confirmPassword = '';
}

if (isset($_POST['username'])) {
    $username = trim($_POST['username']);
} else {
    $username = '';
}

// if (isset($_POST['country']) && array_key_exists($_POST['country'], $countryMap)) {
//     $countryId = $countryMap[$_POST['country']];
// } else {
//     $countryId = 0; 
// }

if (!validateEmail($email)) {
    $_SESSION['error'] = "Nieprawidłowy adres email.";
    header("Location: registerSite.php.php");
    exit;
}

if (!validateUsername($username)) {
    $_SESSION['error'] = "Nazwa użytkownika może zawierać tylko litery, cyfry, kropki i podkreślenia.";
    header("Location: registerSite.php");
    exit;
}

if (empty($email) || empty($password) || empty($confirmPassword) || empty($username)) {
    $_SESSION['error'] = "Wszystkie pola są wymagane.";
    header("Location: registerSite.php");
    exit;
}

if ($password !== $confirmPassword) {
    $_SESSION['error'] = "Hasła nie są zgodne.";
    header("Location: registerSite.php");
    exit;
}

$sql = "SELECT id_użytkownika FROM Użytkownicy WHERE email = ? OR nazwa_użytkownika = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $username); //ochrona przed sql injection
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $_SESSION['error'] = "Email lub nazwa użytkownika jest już zajęta.";
    header("Location: registerSite.php");
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Użytkownicy (nazwa_użytkownika, email, hasło_hash, id_subskrybcji, data_założenia) VALUES (?, ?, ?, 1, CURDATE())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $passwordHash);

if ($stmt->execute()) {
    $_SESSION['success'] = "Rejestracja zakończona sukcesem. Możesz się zalogować.";
    header("Location: loginSite.php");
} else {
    $_SESSION['error'] = "Błąd podczas rejestracji: " . $conn->error;
    header("Location: registerSite.php");
}

$stmt->close();
$conn->close();
?>