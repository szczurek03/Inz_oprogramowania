//funkcja do przewijania kontenera w prawo o szerokość jednej karty + margines
function scrollMore(containerId) {
  const container = document.getElementById(containerId);
  if (!container) return; //jeśli kontener nie istnieje, wyjdź

  const card = container.querySelector('.media-card');
  if (!card) return; //jeśli brak karty w kontenerze, wyjdź

  const cardStyle = getComputedStyle(card); //pobranie stylu karty
  const cardWidth = card.offsetWidth; //szerokość karty
  const marginRight = parseInt(cardStyle.marginRight) || 0; //margines po prawej stronie

  const scrollAmount = cardWidth + marginRight; //łączna odległość przewijania

  container.scrollBy({ left: scrollAmount, behavior: 'smooth' }); //płynne przewinięcie w prawo
}

//funkcja do przewijania kontenera w lewo o stałą wartość
function scrollLess(containerId) {
  const container = document.getElementById(containerId);
  if (container) {
    container.scrollBy({ left: -300, behavior: 'smooth' }); //płynne przewinięcie w lewo o 300px
  }
}
