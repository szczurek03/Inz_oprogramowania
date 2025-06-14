<?php
class UserRegister {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function validateUsername(string $username): bool {
        return preg_match('/^[a-zA-Z0-9._]{3,}$/', $username) === 1;
    }

    public function validateEmail(string $email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function register(string $email, string $username, string $password, string $confirmPassword): array {
        // Walidacja
        if (!$this->validateEmail($email)) {
            return ['error' => "Nieprawidłowy adres email."];
        }

        if (!$this->validateUsername($username)) {
            return ['error' => "Nazwa użytkownika może zawierać tylko litery, cyfry, kropki i podkreślenia."];
        }

        if (empty($email) || empty($password) || empty($confirmPassword) || empty($username)) {
            return ['error' => "Wszystkie pola są wymagane."];
        }

        if ($password !== $confirmPassword) {
            return ['error' => "Hasła nie są zgodne."];
        }

        // Sprawdź, czy email lub nazwa użytkownika są już zajęte
        $sql = "SELECT id_użytkownika FROM Użytkownicy WHERE email = ? OR nazwa_użytkownika = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return ['error' => "Błąd przygotowania zapytania."];
        }
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            return ['error' => "Email lub nazwa użytkownika jest już zajęta."];
        }

        // Hashowanie hasła i zapis do bazy
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Użytkownicy (nazwa_użytkownika, email, hasło_hash, id_subskrybcji, data_założenia) VALUES (?, ?, ?, 1, CURDATE())";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return ['error' => "Błąd przygotowania zapytania."];
        }
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        if ($stmt->execute()) {
            return ['success' => true, 'email' => $email];
        } else {
            return ['error' => "Błąd podczas rejestracji: " . $this->conn->error];
        }
    }
}
?>
