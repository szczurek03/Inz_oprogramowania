<?php
require_once "loginconnect.php";

function validateUsername($username) {
    return preg_match('/^[a-zA-Z0-9._]{3,}$/', $username);
}
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

$countryMap = [
    'pl' => 1,
    'us' => 2,
    'de' => 3,
    'fr' => 4,
    'gb' => 5,
];

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

if (isset($_POST['country']) && array_key_exists($_POST['country'], $countryMap)) {
    $countryId = $countryMap[$_POST['country']];
} else {
    $countryId = 0; 
}


if (!validateEmail($email)) {
    echo "Nieprawidłowy adres email.";
    exit;
}

if (!validateUsername($username)) {
    echo "Nazwa użytkownika może zawierać tylko litery, cyfry, kropki i podkreślenia";
    exit;
}

if (empty($email) || empty($password) || empty($confirmPassword) || empty($username) || $countryId == 0) {
    echo "Wszystkie pola są wymagane.";
    exit;
}

if ($password !== $confirmPassword) {
    echo "Hasła nie są zgodne.";
    exit;
}

$sql = "SELECT id_użytkownika FROM Użytkownicy WHERE email = '$email' OR nazwa_użytkownika = '$username'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo "Email lub nazwa użytkownika jest już zajęta.";
    exit;
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO Użytkownicy (nazwa_użytkownika, email, hasło_hash,id_subskrybcji, data_założenia) 
        VALUES ('$username', '$email', '$passwordHash',1, CURDATE())";

if ($conn->query($sql) === TRUE) {
    echo "Rejestracja zakończona sukcesem.";
} else {
    echo "Błąd podczas rejestracji: " . $conn->error;
}

$conn->close();

?>