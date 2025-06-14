<?php
class Player {
    private $hasSubscription;
    private $title;

    public function __construct(bool $hasSubscription, string $title) {
        $this->hasSubscription = $hasSubscription;
        $this->title = $title;
    }

    public function getPlayLink(): string {
        if ($this->hasSubscription) {
            return 'https://www.youtube.com/results?search_query=' . urlencode($this->title . ' trailer');
        } else {
            return 'sub.php';
        }
    }
}
?>