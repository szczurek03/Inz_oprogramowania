<?php
//klasa odpowiadająca za generowanie linku do odtwarzania filmu
class Player {
    private $hasSubscription; //czy użytkownik ma aktywną subskrypcję
    private $title; //tytuł filmu

    //konstruktor klasy
    public function __construct(bool $hasSubscription, string $title) {
        $this->hasSubscription = $hasSubscription;
        $this->title = $title;
    }

    //funkcja zwracająca odpowiedni link do odtwarzania
    public function getPlayLink(): string {
        if ($this->hasSubscription) {
            //jeśli użytkownik ma subskrypcję – szuka zwiastuna na YouTube
            return 'https://www.youtube.com/results?search_query=' . urlencode($this->title . ' trailer');
        } else {
            //jeśli nie – przekierowuje do strony zakupu subskrypcji
            return 'sub.php';
        }
    }
}
?>
