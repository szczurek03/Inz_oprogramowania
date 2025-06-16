<?php
session_start();

class SessionManager {
    private $userId;
    private $isEmployee;

    public function __construct() {
        $this->userId = $_SESSION['user_id'] ?? null;
        if ($this->userId === null) {
            header('Location: loginSite.php');
            exit;
        }

        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        if (!isset($_SESSION['email']) && isset($_COOKIE['user_email'])) {
            $_SESSION['email'] = $_COOKIE['user_email'];
        }
    }

    public function checkEmployeeStatus(Database $db) {
        $stmt = $db->getConnection()->prepare("SELECT czy_pracownik FROM użytkownicy WHERE id_użytkownika = ?");
        if (!$stmt) {
            die("Błąd SQL: " . $db->getConnection()->error);
        }
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $this->isEmployee = ($row = $result->fetch_assoc()) && $row['czy_pracownik'] == 1;
        $stmt->close();
        if (!$this->isEmployee) {
            header('Location: home.php');
            exit;
        }
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getUsername() {
        return $_SESSION['nazwa_użytkownika'] ?? 'Użytkownik';
    }
}

class Database {
    private $conn;

    public function __construct() {
        require_once "loginconnect.php";
        $this->conn = $conn;
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function close() {
        $this->conn->close();
    }
}

class RequestListHandler {
    private $db;
    private $requests = [];

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function fetchRequests() {
        $stmt = $this->db->getConnection()->prepare("
            SELECT p.id_prośby, p.id_użytkownika, u.nazwa_użytkownika, p.prośba, p.id_status_prośby, 
                   sp.nazwa_statusu, p.data_wysłania
            FROM prośby p
            LEFT JOIN użytkownicy u ON p.id_użytkownika = u.id_użytkownika
            LEFT JOIN status_prośby sp ON p.id_status_prośby = sp.id_status_prośby
            ORDER BY p.data_wysłania DESC
        ");
        if (!$stmt) {
            die("Błąd SQL: " . $this->db->getConnection()->error);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $this->requests[] = $row;
        }
        $stmt->close();
    }

    public function getRequests() {
        return $this->requests;
    }
}

class ViewRenderer {
    private $username;
    private $requests;

    public function __construct($username, $requests) {
        $this->username = $username;
        $this->requests = $requests;
    }

    private function truncateText($text, $charLimit = 30) {
        if (mb_strlen($text) <= $charLimit) {
            return $text;
        }
        return mb_substr($text, 0, $charLimit) . '...';
    }

    public function render() {
        ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleH.css" />
    <link rel="stylesheet" href="styleReq.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Zarządzaj prośbami</title>
</head>
<body>
    <a href="settings.php" class="back-btn" data-i18n="back" title="Powrót">
        <i class="fas fa-arrow-left"></i>
    </a>
    <header>
        <img src="logo.png" alt="Streamflix Logo" class="logo" />
        <div class="user-info">
            <span class="username"><?php echo htmlspecialchars($this->username); ?></span>
            <i class="fas fa-user-circle"></i>
            <a href="settings.php" class="icon-btn" data-i18n-tooltip="settings" title="Ustawienia">
                <i class="fas fa-cog"></i>
            </a>
            <a href="logout.php" class="icon-btn" data-i18n-tooltip="logout" title="Wyloguj się">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </header>

    <div class="manage-container">
        <h1 data-i18n="manage-requests">Zarządzaj <span>Prośbami</span></h1>
        <div class="subtitle" data-i18n="view-requests">Przeglądaj zgłoszone prośby użytkowników</div>

         <div class="requests-table">
            <?php if (empty($this->requests)): ?>
                <div class="no-requests">Brak zgłoszonych próśb.</div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Użytkownik</th>
                            <th>Prośba</th>
                            <th>Status</th>
                            <th>Data Wysłania</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->requests as $request): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($request['id_prośby']); ?></td>
                                <td><?php echo htmlspecialchars($request['nazwa_użytkownika'] ?? 'Nieznany'); ?></td>
                                <td class="request-cell"><?php echo htmlspecialchars($this->truncateText($request['prośba'])); ?></td>
                                <td><?php echo htmlspecialchars($request['nazwa_statusu']); ?></td>
                                <td>
                                    <?php
                                    if ($request['data_wysłania'] === '0000-00-00' || empty($request['data_wysłania'])) {
                                        echo 'Brak daty';
                                    } else {
                                        $date = DateTime::createFromFormat('Y-m-d', $request['data_wysłania']);
                                        echo $date ? htmlspecialchars($date->format('d-m-Y')) : 'Nieprawidłowa data';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
        <?php
    }
}

$db = new Database();
$session = new SessionManager();
$session->checkEmployeeStatus($db);
$requestListHandler = new RequestListHandler($db);
$requestListHandler->fetchRequests();
$view = new ViewRenderer($session->getUsername(), $requestListHandler->getRequests());

$view->render();

$db->close();
?>