//funkcja do przesłania oceny użytkownika (like/dislike) dla danego tytułu
function sendRating(title, action) {
    //wysłanie zapytania GET do skryptu PHP z parametrami tytułu i typu akcji
    fetch(`like.php?title=${encodeURIComponent(title)}&action=${action}`)
        .then(response => response.text()) //odczyt odpowiedzi jako tekst
        .then(data => {
            alert(data); //wyświetlenie odpowiedzi w oknie alert
            window.location.reload(); //odświeżenie strony, by zaktualizować stan
        })
        .catch(err => alert("Błąd: " + err)); //obsługa błędów np. brak połączenia
}
