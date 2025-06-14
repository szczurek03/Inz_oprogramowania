<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../movie_preview.php';
require_once __DIR__ . '/../player.php';
class PlayerTest extends TestCase {
   private $conn;

    protected function setUp(): void {
        $this->conn = new mysqli("localhost", "root", "", "streaming");
    }
    protected function tearDown(): void {
        $this->conn->close();
    }

    public function testPlayerWithoutSubscription() {
        $title = "Testowy Film";
        $player = new Player(false, $title);
        $link = $player->getPlayLink();
        $this->assertEquals('sub.php', $link);
    }

    public function testPlayerWithSubscription() {
        $title = "Testowy Film";
        $player = new Player(true, $title);
        $link = $player->getPlayLink();
        $expectedPrefix = 'https://www.youtube.com/results?search_query=';
        $this->assertStringStartsWith($expectedPrefix, $link);
        $this->assertStringContainsString(urlencode($title . ' trailer'), $link);
    }

}
?>