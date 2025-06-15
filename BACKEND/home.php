<?php
session_start();
$user_id = $_SESSION['user_id'] ?? null; //sprawdzenie, czy użytkownik jest zalogowany
if ($user_id === null) {
  //jeśli nie jest zalogowany – przekieruj na stronę logowania
    header('Location: loginSite.php');
    exit;
}
//wyłączenie cache’owania dla aktualności treści
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
//jeśli email w sesji jest pusty, ale jest w ciasteczku, to go przywróć
if (!isset($_SESSION['email']) && isset($_COOKIE['user_email'])) {
    $_SESSION['email'] = $_COOKIE['user_email'];   
}

require_once "loginconnect.php";

$filmy_tytuly = [];

if ($user_id !== null) {
   //jeśli brak nazwy użytkownika w sesji, to pobierz ją z bazy
  if (!isset($_SESSION['nazwa_użytkownika']) && $user_id !== null) {
    $stmt_user = $conn->prepare("SELECT nazwa_użytkownika FROM użytkownicy WHERE id_użytkownika = ?");
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    if ($row_user = $result_user->fetch_assoc()) {
        $_SESSION['nazwa_użytkownika'] = $row_user['nazwa_użytkownika'];
    }
    $stmt_user->close();
}
  //jeśli użytkownik kliknął "Odśwież rekomendacje"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refresh_recommendations'])) {
        $stmt_delete = $conn->prepare("DELETE FROM rekomendacje WHERE id_użytkownika = ?");
        $stmt_delete->bind_param("i", $user_id);
        $stmt_delete->execute();

         //wybierz nowe rekomendacje na podstawie polubień gatunków
        $sql_new_recommendations = "SELECT DISTINCT t.id_tresc
          FROM treść2 t
          WHERE t.typ = 'film'
            AND t.id_gatunek IN (
              SELECT t2.id_gatunek
              FROM treść2 t2
              JOIN oceny o ON t2.id_tresc = o.id_treść
              WHERE o.id_użytkownika = ? AND o.id_like = 1
            )
          ORDER BY RAND()
          LIMIT 10
        ";

        $stmt_reco = $conn->prepare($sql_new_recommendations);
        $stmt_reco->bind_param("i", $user_id);
        $stmt_reco->execute();
        $result_reco = $stmt_reco->get_result();

        //zapisz nowe rekomendacje do bazy
        while ($row = $result_reco->fetch_assoc()) {
            $id_tresc = $row['id_tresc'];
            $stmt_insert = $conn->prepare("INSERT INTO rekomendacje (id_użytkownika, id_treść) VALUES (?, ?)");
            $stmt_insert->bind_param("ii", $user_id, $id_tresc);
            $stmt_insert->execute();
        }
        //odśwież stronę
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
    //pobierz rekomendowane filmy z tabeli
    $sql_filmy = "   SELECT t.tytuł, t.img
    FROM treść2 t
    JOIN rekomendacje r ON t.id_tresc = r.id_treść
    WHERE r.id_użytkownika = ?
    LIMIT 10";

    $stmt = $conn->prepare($sql_filmy);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $filmy_tytuly = [];
    while ($row = $result->fetch_assoc()) {
        $filmy_tytuly[] = $row;
    }
    $stmt->close();
  }
 //pobranie filmów polubionych przez użytkownika
  $polubione_filmy = [];

$sql_liked = "
  SELECT t.tytuł, t.img
  FROM treść2 t
  JOIN oceny o ON t.id_tresc = o.id_treść
  WHERE o.id_użytkownika = ? AND o.id_like = 1 AND t.typ = 'film'
";

$stmt_liked = $conn->prepare($sql_liked);
$stmt_liked->bind_param("i", $user_id);
$stmt_liked->execute();
$result_liked = $stmt_liked->get_result();

while ($row = $result_liked->fetch_assoc()) {
    $polubione_filmy[] = $row;
}
$stmt_liked->close();
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
      <span class="username"><?php echo $_SESSION['nazwa_użytkownika']; ?></span>
      <i class="fas fa-user-circle"></i>
      <a href="settings.php" class="icon-btn" data-i18n-tooltip="settings" title="Ustawienia">
            <i class="fas fa-cog"></i>
      </a>
      <a href="logout.php" class="icon-btn" data-i18n-tooltip="logout" title="Wyloguj się">
            <i class="fas fa-sign-out-alt"></i>
      </a>
     
    </div>
  </header>
  <!-- wyszukiwarka filmów -->
  <section class="search-section">
    <form method="get" action="movie_preview.php">
      <div class="search-bar">
      <i class="fas fa-search"></i>
      <input type="text" name="title" placeholder="Wyszukaj film lub serial" required />
       </div>
</form>
    <h2 class="recommendation-title">Przeglądaj rekomendacje przygotowane dla ciebie:</h2>
  </section>
<!-- sekcja rekomendacji -->
  <section class="media-section">
    <div class="media-wrapper">
        <h3>Top 10 filmów dla Ciebie</h3>
        <p>Sprawdź, co nasz system rekomendacji przygotował specjalnie dla Ciebie – oceń filmy i dopasuj je do swoich upodobań!</p>
        <form method="post" action="">
  <button type="submit" name="refresh_recommendations">Odśwież rekomendacje</button>
</form>
    </div>
    <div class="right">
      <div class="media-row">
        <div class="media-container" id="movies">
           <!-- lista kart filmów -->
          <?php foreach ($filmy_tytuly as $index => $film): ?>

            <a href="movie_preview.php?title=<?php echo urlencode($film['tytuł']); ?>&source=home" class="media-card-link">
            <div class="media-card">
              <img src="<?php echo htmlspecialchars($film['img']); ?>" alt="Film <?php echo $index + 1; ?>" />
              <div class="card-meta">
                <span class="number"><?php echo $index + 1; ?></span>
                <p class="title"><?php echo htmlspecialchars($film['tytuł']); ?></p>
              </div>
            </div>
            </a>


          <?php endforeach; ?>
        </div>
        <!-- strzałki do przewijania jeśli za dużo filmów -->
        <?php if (count($filmy_tytuly) >= 10): ?>
        <div class="more-arrow" onclick="scrollMore('movies')">
          <i class="fas fa-arrow-right"></i>
        </div>
        <div class="more-arrow" onclick="scrollLess('movies')">
          <i class="fas fa-arrow-left"></i>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
 <!-- sekcja z polubionymi filmami -->
<section class="media-section">
  <div class="media-wrapper">
    <h3>Twoje polubione filmy</h3>
    <p>Filmy, które oznaczyłeś jako "lubię to".</p>
  </div>
  <div class="right">
    <div class="media-container" id="liked">
      <?php foreach ($polubione_filmy as $index => $film): ?>
        <a href="movie_preview.php?title=<?php echo urlencode($film['tytuł']); ?>&source=home" class="media-card-link">
          <div class="media-card">
            <img src="<?php echo htmlspecialchars($film['img']); ?>" alt="Film <?php echo $index + 1; ?>" />
            <div class="card-meta">
              <p class="title"><?php echo htmlspecialchars($film['tytuł']); ?></p>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <!-- strzałki przewijania -->
    <?php if (count($polubione_filmy) >= 6): ?>
      <div class="more-arrow" onclick="scrollMore('liked')">
        <i class="fas fa-arrow-right"></i>
      </div>
      <div class="media-row">
        <div class="more-arrow" onclick="scrollLess('liked')">
          <i class="fas fa-arrow-left"></i>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
  <script src="script.js"></script>
</body>
</html>
