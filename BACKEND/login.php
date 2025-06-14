<?php
session_start();
require_once "loginconnect.php";  // tu masz połączenie $conn
require_once "UserAuth.php";

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    $_SESSION['error'] = "Proszę wypełnić wszystkie pola.";
    header("Location: loginSite.php");
    exit();
}

$auth = new UserAuth($conn);
$result = $auth->login($_POST['email'], $_POST['password']);

if (isset($result['success']) && $result['success']) {
    $_SESSION['user_id'] = $result['user_id'];
    $_SESSION['email'] = $result['email'];
    setcookie("user_email", $result['email'], time() + (7 * 24 * 60 * 60), "/");
    $_SESSION['success'] = "Zalogowano pomyślnie!";
    header("Location: home.php");
    exit();
} else {
    $_SESSION['error'] = $result['error'];
    header("Location: loginSite.php");
    exit();
}
?>
