function sendRating(title, action) {
    fetch(`like.php?title=${encodeURIComponent(title)}&action=${action}`)
        .then(response => response.text())
        .then(data => alert(data))
        .catch(err => alert("Błąd: " + err));
}