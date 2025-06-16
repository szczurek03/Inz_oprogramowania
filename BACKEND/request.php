<?php
session_start();

class SessionManager {
    private $userId;

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

class RequestHandler {
    private $db;
    private $userId;
    private $message = '';
    private $messageType = '';

    public function __construct(Database $db, $userId) {
        $this->db = $db;
        $this->userId = $userId;
    }

    public function processRequest() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['request'])) {
            return;
        }

        $requestText = trim($_POST['request']);
        if (empty($requestText)) {
            $this->message = "Prośba nie może być pusta.";
            $this->messageType = 'error';
            return;
        }
        if (strlen($requestText) > 255) {
            $this->message = "Prośba nie może przekraczać 255 znaków.";
            $this->messageType = 'error';
            return;
        }

        $stmt = $this->db->getConnection()->prepare("
            INSERT INTO prośby (id_użytkownika, prośba, id_status_prośby, data_wysłania)
            VALUES (?, ?, 1, ?)
        ");
        if (!$stmt) {
            $this->message = "Błąd bazy danych: " . htmlspecialchars($this->db->getConnection()->error);
            $this->messageType = 'error';
            return;
        }

        $date = (new DateTime())->format('Y-m-d');
        $stmt->bind_param("iss", $this->userId, $requestText, $date);
        if ($stmt->execute()) {
            $this->message = "Prośba została wysłana pomyślnie!";
            $this->messageType = 'success';
            header("Location: request.php?message=" . urlencode($this->message) . "&type=success");
            exit;
        } else {
            $this->message = "Błąd podczas wysyłania prośby: " . htmlspecialchars($stmt->error);
            $this->messageType = 'error';
        }
        $stmt->close();
    }

    public function getMessage() {
        if (isset($_GET['message'], $_GET['type'])) {
            $this->message = htmlspecialchars($_GET['message']);
            $this->messageType = ($_GET['type'] === 'success') ? 'success' : 'error';
        }
        return ['text' => $this->message, 'type' => $this->messageType];
    }
}

class ViewRenderer {
    private $username;
    private $message;

    public function __construct($username, $message) {
        $this->username = $username;
        $this->message = $message;
    }

    public function render() {
        ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleReq.css" />
    <link rel="stylesheet" href="styleH.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <title>Zgłoś prośbę</title>

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

    <div class="request-container">
        <h1 data-i18n="request">Zgłoś <span>Prośbę</span></h1>
        <div class="subtitle" data-i18n="submit-request">Wpisz swoją prośbę poniżej</div>

        <div class="request-form">
            <?php if ($this->message['text']): ?>
                <div class="message <?php echo $this->message['type']; ?>">
                    <?php echo $this->message['text']; ?>
                </div>
            <?php endif; ?>
            <form method="POST" action="request.php">
                <textarea name="request" placeholder="Wpisz swoją prośbę (maks. 255 znaków)" maxlength="255" required></textarea>
                <button type="submit">Wyślij prośbę</button>
            </form>
        </div>
    </div>

    <script src="scriptRL.js"></script>
</body>
</html>
        <?php
    }
}

$session = new SessionManager();
$db = new Database();
$requestHandler = new RequestHandler($db, $session->getUserId());
$requestHandler->processRequest();
$view = new ViewRenderer($session->getUsername(), $requestHandler->getMessage());

$view->render();

$db->close();
?>