<?php
session_start();
//jezeli user_id sesji nie istnieje przekierowywuje spowrotem na strone logowania
$user_id = $_SESSION['user_id'] ?? null;
if ($user_id === null) {
    header('Location: loginSite.php');
    exit;
}

//Dane wrazliwe - nie przechowujemy w cache
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

if (!isset($_SESSION['email']) && isset($_COOKIE['user_email'])) {
    $_SESSION['email'] = $_COOKIE['user_email'];   
}

require_once "loginconnect.php";


//pobiera dane subskyrpcji dla danego uzytkownika
$stmt = $conn->prepare("
    SELECT ns.nazwa_subskrybcji as nazwa, s.data_zakończenia, s.cena, s.aktywny as status
    FROM użytkownicy u
    JOIN subskrybcja s ON u.id_subskrybcji = s.id_subskrybcji
    JOIN nazwa_subskrybcji ns ON s.id_nazwa_subskrybcji = ns.id_nazwa_subskrybcji
    WHERE u.id_użytkownika = ?
");
if (!$stmt) {
    die("Błąd SQL: " . $conn->error);
}
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();



$subscription = [
    'nazwa' => 'Brak',
    'data_zakończenia' => '',
    'cena' => 0,
    'status' => 'Brak',
    'remaining_days' => 0
];

if ($row = $result->fetch_assoc()) {
    $subscription['nazwa'] = $row['nazwa'];
    $subscription['data_zakończenia'] = $row['data_zakończenia'];
    $subscription['cena'] = $row['cena'];
    $subscription['status'] = $row['status'];

    $end_date = new DateTime($row['data_zakończenia']);
    $today = new DateTime('2025-06-09'); 
    $interval = $today->diff($end_date);
    $remaining_days = $interval->days;
    if ($today > $end_date) {
        $remaining_days = 0;
        $subscription['status'] = 'Nieaktywna';
    }
    else{
         $subscription['status'] = 'Aktywna';
    }
    $subscription['remaining_days'] = $remaining_days;
}
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleH.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Status subskrypcji</title>
</head>
</head>
<body>
    <a href="home.php" class="back-btn" data-i18n="back" title="Powrót">
        <i class="fas fa-arrow-left"></i>
    </a>
    <header>
        <img src="logo.png" alt="Streamflix Logo" class="logo" />
        <div class="user-info">
            <span class="username"><?php echo htmlspecialchars($_SESSION['nazwa_użytkownika'] ?? 'Użytkownik'); ?></span>
            <i class="fas fa-user-circle"></i>
            <a href="settings.php" class="icon-btn" data-i18n-tooltip="settings" title="Ustawienia">
                <i class="fas fa-cog"></i>
            </a>
            <a href="logout.php" class="icon-btn" data-i18n-tooltip="logout" title="Wyloguj się">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </header>

    <div class="settings-container">
        <h1 data-i18n="settings">Ustawienia <span>Streamflix</span></h1>
        <div class="subtitle" data-i18n="manage-subscription">Zarządzaj subskrypcją</div>

        <div class="plan-set">
            <p>Twoja subskrypcja: <strong><?php echo htmlspecialchars($subscription['nazwa']); ?></strong></p>
            <p>Data zakończenia subskrypcji: <strong><?php echo htmlspecialchars($subscription['data_zakończenia']); ?></strong> ❗</p>
            <p>Status: <strong class="status-active"><?php echo htmlspecialchars($subscription['status']); ?></strong>
            <span class="status-remaining">( pozostało <?php echo $subscription['remaining_days']; ?> dni )</span></p>
            <p>Obecna cena: <span class="price"><?php echo number_format($subscription['cena'], 2); ?>zł</span></p>
        </div>
        <?php if ($subscription['status'] == 'Aktywna'): ?>
            <form action="purchase.php" method="POST">
                <input type="hidden" name="plan" value="Brak">
                <button type="submit" class="cancel-sub"><b>Anuluj subskrypcję</b></button>
            </form>
            <?php endif; ?>

        <a href="sub.php" class="upgrade-link" >Przejdź do strony zakupu!</a>

        <div class="plans">
                <span class="plan-icon smile"></span>
            <div class="plan plan-benefits">
                <h2>Premium zapewnia:</h2>
                <ul>
                    <li >Możliwość pobierania filmów offline</li>
                    <li >Wczesny dostęp do premier</li>
                    <li >Lepszą jakość treści oraz dźwięku</li>
                </ul>
            </div>
                <span class="plan-icon star"></span>
        </div>
    </div>

    <script src="scriptRL.js"></script>
</body>
</html>
