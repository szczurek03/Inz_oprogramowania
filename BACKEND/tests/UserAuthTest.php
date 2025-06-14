<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../UserAuth.php';
require_once __DIR__ . '/../UserRegister.php';
require_once __DIR__ . '/../logout_functions.php'; 

ob_start();
class UserAuthTest extends TestCase {
private $conn;

    protected function setUp(): void {
        $this->conn = new mysqli("localhost", "root", "", "streaming");
    }

    protected function tearDown(): void {
        $this->conn->close();
    }

    public function testLoginSuccess() {
        $auth = new UserAuth($this->conn);
        $result = $auth->login("klaudiakrawiec2003@gmail.com", "Kalifornia1");
        $this->assertArrayHasKey('success', $result);
        $this->assertTrue($result['success']);
        $this->assertEquals("klaudiakrawiec2003@gmail.com", $result['email']);
    } 
    public function testRegisterSuccess() {
        $register = new UserRegister($this->conn);
        $email = "testuser@example.com";
        $username = "testuser";
        $password = "StrongPass123";

        $result = $register->register($email, $username, $password, $password);

        $this->assertArrayHasKey('success', $result);
        $this->assertTrue($result['success']);

        $this->conn->query("DELETE FROM Użytkownicy WHERE email = '$email'");
    }

public function testLogoutUser()
{
    session_start();
    
    $_SESSION = [
        'user_id' => 1,
        'nazwa_użytkownika' => 'testuser',
        'email' => 'test@example.com'
    ];
    $_COOKIE['user_email'] = 'test@example.com';

    logoutUser();

    $this->assertArrayNotHasKey('user_id', $_SESSION);
    $this->assertArrayNotHasKey('nazwa_użytkownika', $_SESSION);
    $this->assertArrayNotHasKey('email', $_SESSION);

}

}
?>