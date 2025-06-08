<?php
session_start();
require_once "loginconnect.php";

if (!isset($_SESSION['email'], $_GET['title'], $_GET['action'])) {
    exit("Brak danych");
}

$email = $_SESSION['email'];
$title = $_GET['title'];
$action = $_GET['action'];

$LIKE_ID = 1;
$DISLIKE_ID = 2;
$rating = ($action === 'like') ? $LIKE_ID : (($action === 'dislike') ? $DISLIKE_ID : null);

if (!$rating) {
    exit("Nieprawidłowa akcja");
}

$sql = "SELECT u.id_użytkownika, t.id_tresc
        FROM użytkownicy u, treść2 t
        WHERE u.email = ? AND t.tytuł = ?
        LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $title);
$stmt->execute();
$stmt->bind_result($id_user, $id_tresc);
if (!$stmt->fetch()) exit("Nie znaleziono danych");
$stmt->close();


$sql = "SELECT id_oceny, id_like FROM oceny WHERE id_użytkownika = ? AND id_treść = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_user, $id_tresc);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if ($row) {
    if ($row['id_like'] == $rating) {
        exit("Już oceniono tym samym sposobem");
    } else {
        $sql = "UPDATE oceny SET id_like = ?, data_oceny = NOW() WHERE id_oceny = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $rating, $row['id_oceny']);
        $stmt->execute();
        echo $stmt->affected_rows > 0 ? "Zmieniono ocenę na " . $action : "Nie udało się zmienić oceny";
        $stmt->close();
    }
} else {
    $sql = "INSERT INTO oceny (id_użytkownika, id_like, data_oceny, id_treść)
            VALUES (?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id_user, $rating, $id_tresc);
    $stmt->execute();
    echo $stmt->affected_rows > 0 ? "Dodano " . $action : "Błąd przy dodawaniu oceny";
    $stmt->close();
}
?>
