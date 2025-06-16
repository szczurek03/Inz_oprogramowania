function scrollMore(containerId) {
  const container = document.getElementById(containerId);
  if (!container) return;

  const card = container.querySelector('.media-card');
  if (!card) return;

  const cardStyle = getComputedStyle(card);
  const cardWidth = card.offsetWidth;
  const marginRight = parseInt(cardStyle.marginRight) || 0;

  const scrollAmount = cardWidth + marginRight;

  container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
}


function scrollLess(containerId) {
  const container = document.getElementById(containerId);
  if (container) { 
    container.scrollBy({ left: -300, behavior: 'smooth' });
    
  }
}
