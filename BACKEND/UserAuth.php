<?php
//klasa obsługująca logikę logowania użytkownika
class UserAuth {
    private $conn; //połączenie z bazą danych

    //konstruktor klasy przyjmuje obiekt mysqli
    public function __construct(mysqli $conn) {
        $this->conn = $conn;
    }

    //funkcja logowania użytkownika
    public function login(string $email, string $password): array {
        //zapytanie pobierające dane użytkownika po adresie e-mail
        $sql = "SELECT id_użytkownika, email, hasło_hash FROM Użytkownicy WHERE email = ?";
        $stmt = $this->conn->prepare($sql);

        //jeśli nie uda się przygotować zapytania
        if (!$stmt) {
            return ['error' => "Błąd przygotowania zapytania"];
        }

        //powiązanie parametru i wykonanie zapytania
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        //jeśli użytkownik istnieje
        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            //weryfikacja hasła z hashem z bazy
            if (password_verify($password, $user['hasło_hash'])) {
                return [
                    'success' => true,
                    'user_id' => $user['id_użytkownika'],
                    'email' => $user['email']
                ];
            } else {
                return ['error' => "Błędne hasło."]; //niepoprawne hasło
            }
        } else {
            return ['error' => "Nie znaleziono użytkownika."]; //brak konta
        }
    }
}
?>
