<?php
session_start();

if (!isset($_SESSION['email']) && isset($_COOKIE['user_email'])) {
    $_SESSION['email'] = $_COOKIE['user_email'];
}

require_once "loginconnect.php";

$filmy_tytuly = [];
$sql_filmy = "SELECT tytuł, img_mini FROM treść WHERE typ = 'film' LIMIT 10";
$filmy = $conn->query($sql_filmy);

$filmy_tytuly = [];
$sql_filmy = "SELECT tytuł, img_mini FROM treść WHERE typ = 'film' LIMIT 10";
$filmy = $conn->query($sql_filmy);

if ($filmy) {
    while ($row = $filmy->fetch_assoc()) {
        $filmy_tytuly[] = [
            'tytuł' => $row['tytuł'],
            'img_mini' => $row['img_mini']
        ];
    }
} else {
    echo "Błąd: " . $conn->error;
}

$seriale_tytuly = [];
$sql_seriale = "SELECT tytuł, img_mini FROM treść WHERE typ = 'serial' LIMIT 10";
$seriale = $conn->query($sql_seriale);

if ($seriale) {
    while ($row = $seriale->fetch_assoc()) {
        $seriale_tytuly[] = [
            'tytuł' => $row['tytuł'],
            'img_mini' => $row['img_mini']
        ];
    }
} else {
    echo "Błąd: " . $conn->error;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Streamflix - Strona główna</title>
  <link rel="stylesheet" href="styleH.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>
  <header>
    <img src="logo.png" alt="Streamflix Logo" class="logo" />
    <div class="user-info">
      <span class="username">
        <?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'Gość'; ?>
      </span>
      <i class="fas fa-user-circle"></i>
      <i class="fas fa-cog"></i>
      <?php if (isset($_SESSION['email'])): ?>
        <a href="logout.php" class="logout-button">Wyloguj</a>
      <?php endif; ?>
    </div>
  </header>

  <section class="search-section">
    <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" placeholder="Wyszukaj film lub serial" />
    </div>
    <h2 class="recommendation-title">Przeglądaj rekomendacje przygotowane dla ciebie:</h2>
  </section>

  <section class="media-section">
    <div class="media-wrapper">
      <div class="section-text">
        <h3>Top 10 filmów dla Ciebie</h3>
        <p>Sprawdź, co nasz system rekomendacji przygotował specjalnie dla Ciebie – oceń filmy i dopasuj je do swoich upodobań!</p>
      </div>
      <div class="media-row">
        <div class="media-container" id="movies">
                <?php foreach ($filmy_tytuly as $index => $film): ?>
            <div class="media-card">
              <img src="<?php echo htmlspecialchars($film['img_mini'] ?? 'placeholder.jpg'); ?>" alt="Film <?= $index + 1 ?>" />
              <div class="card-meta">
                <span class="number"><?= $index + 1 ?></span>
                <p class="title"><?= htmlspecialchars($film['tytuł']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="more-arrow" onclick="scrollMore('movies')">
          <span>więcej</span>
          <i class="fas fa-arrow-right"></i>
        </div>
      </div>
    </div>
  </section>

  <section class="media-section">
    <div class="media-wrapper">
      <div class="section-text">
        <h3>Top 10 seriali dla Ciebie</h3>
        <p>Sprawdź, co nasz system rekomendacji przygotował specjalnie dla Ciebie – oceń seriale i dopasuj je do swoich upodobań!</p>
      </div>
      <div class="media-row">
        <div class="media-container" id="series">
         <?php foreach ($seriale_tytuly as $index => $serial): ?>
            <div class="media-card">
              <img src="<?php echo htmlspecialchars($serial['img_mini'] ?? 'placeholder.jpg'); ?>" alt="Serial <?= $index + 1 ?>" />
              <div class="card-meta">
                <span class="number"><?= $index + 1 ?></span>
                <p class="title"><?= htmlspecialchars($serial['tytuł']) ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div class="more-arrow" onclick="scrollMore('series')">
          <span>więcej</span>
          <i class="fas fa-arrow-right"></i>
        </div>
      </div>
    </div>
  </section>
</body>
</html>
