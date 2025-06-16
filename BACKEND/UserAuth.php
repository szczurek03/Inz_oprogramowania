<?php
class UserAuth {
    private $conn;

    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    public function login(string $email, string $password): array {
        $sql = "SELECT id_użytkownika, email, hasło_hash FROM Użytkownicy WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return ['error' => "Błąd przygotowania zapytania"];
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['hasło_hash'])) {
                return [
                    'success' => true,
                    'user_id' => $user['id_użytkownika'],
                    'email' => $user['email']
                ];
            } else {
                return ['error' => "Błędne hasło."];
            }
        } else {
            return ['error' => "Nie znaleziono użytkownika."];
        }
    }
}
?>
