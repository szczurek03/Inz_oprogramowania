<?php
session_start();

$user_id = $_SESSION['user_id'] ?? null;
//jeśli użytkownik nie jest zalogowany, przekieruj do logowania
if ($user_id === null) {
    header('Location: loginSite.php');
    exit;
}

require_once "loginconnect.php";

$plan = $_POST['plan'] ?? '';

//mapowanie planów subskrypcji na dane
$plan_details = [
    'Regular' => [
        'id_nazwa_subskrybcji' => 2,
        'cena' => 39.99,
        'aktywny' => 1,
        'data_zakończenia' => date('Y-m-d', strtotime('+30 days'))
    ],
    'Premium' => [
        'id_nazwa_subskrybcji' => 3,
        'cena' => 59.99,
        'aktywny' => 1,
        'data_zakończenia' => date('Y-m-d', strtotime('+30 days'))
    ],
    'Brak' => [
        'id_nazwa_subskrybcji' => 1,
        'cena' => 0,
        'aktywny' => 0,
        'data_zakończenia' => date('Y-m-d')
    ]
];

$plan_id = $plan_details[$plan]['id_nazwa_subskrybcji'];
$price = $plan_details[$plan]['cena'];
$aktywny = $plan_details[$plan]['aktywny'];
$end_date = $plan_details[$plan]['data_zakończenia'];

$conn->begin_transaction(); //rozpoczęcie transakcji

//dodanie nowej subskrypcji do tabeli
$stmt_sub = $conn->prepare("
    INSERT INTO subskrybcja (id_nazwa_subskrybcji, data_zakończenia, cena, aktywny)
    VALUES (?, ?, ?, ?)
");
$stmt_sub->bind_param("isdi", $plan_id, $end_date, $price, $aktywny);
$stmt_sub->execute();
$new_sub_id = $conn->insert_id;
$stmt_sub->close();

//aktualizacja użytkownika - przypisanie nowej subskrypcji
$stmt_user = $conn->prepare("
    UPDATE użytkownicy
    SET id_subskrybcji = ?
    WHERE id_użytkownika = ?
");
$stmt_user->bind_param("ii", $new_sub_id, $user_id);
$stmt_user->execute();
$stmt_user->close();

$conn->commit(); //zatwierdzenie transakcji

//przekierowanie do ustawień
header('Location: settings.php');
$conn->close();
?>
