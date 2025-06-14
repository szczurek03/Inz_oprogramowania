<?php
session_start();
require_once "loginconnect.php";
require_once 'player.php';

$user_id = $_SESSION['user_id'] ?? null;
$title = trim($_GET['title'] ?? '');
$source = $_GET['source'] ?? 'search';

if (empty($title)) {
    $error_message = "Brak tytułu do wyszukania.";
} else {
    $sql = "SELECT 
        t.id_tresc,
        t.tytuł,
        t.opis,
        t.rok_wydania AS rok,
        t.długość AS długość,
        t.img,
        g.nazwa_gatunku AS gatunek,
        k.nazwa_kraju AS kraj,
        kw.nazwa_kategorii_wiekowej AS kategoria_wiekowa
    FROM treść2 t
    JOIN gatunek2 g ON t.id_gatunek = g.id_gatunek
    JOIN kraj2 k ON t.id_kraj = k.id_kraj
    JOIN kategoria_wiekowa2 kw ON t.id_kategoria_wiekowa = kw.id_kategoria_wiekowa
    WHERE ";

    if ($source === 'home') {
        $sql .= "t.tytuł = ?";
        $title_param = $title;
    } else {
        $sql .= "t.tytuł LIKE ?";
        $title_param = '%' . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . '%';
    }

    $sql .= " LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $title_param);
    $stmt->execute();
    $result = $stmt->get_result();

    $film = $result->fetch_assoc();

    if (!$film) {
        $error_message = "Film nie został znaleziony.";
    } else {
        if ($user_id) {
            $stmt_rating = $conn->prepare("
                SELECT id_like 
                FROM oceny 
                WHERE id_użytkownika = ? AND id_treść = ?
            ");
            $stmt_rating->bind_param("ii", $user_id, $film['id_tresc']);
            $stmt_rating->execute();
            $result_rating = $stmt_rating->get_result();
            $rating = $result_rating->fetch_assoc();
            $stmt_rating->close();
        }
        $hasSubscription = false;

        if ($user_id) {
            $stmt_sub = $conn->prepare("
                SELECT ns.id_nazwa_subskrybcji 
                FROM użytkownicy u
                JOIN subskrybcja s ON u.id_subskrybcji = s.id_subskrybcji
                JOIN nazwa_subskrybcji ns ON s.id_nazwa_subskrybcji = ns.id_nazwa_subskrybcji
                WHERE u.id_użytkownika = ?
            ");
            $stmt_sub->bind_param("i", $user_id);
            $stmt_sub->execute();
            $result_sub = $stmt_sub->get_result();

            if ($row = $result_sub->fetch_assoc()) {
                $hasSubscription = ($row['id_nazwa_subskrybcji'] != 1);
            }
            $stmt_sub->close();
        }

    }

    

    $stmt->close();
}

$conn->close();
 if (isset($error_message)): ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Streamflix - Błąd</title>
    <link rel="stylesheet" href="styleH.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="styleP.css" />
</head>
<body>
    <div class="center-wrapper">
    <div class="error-container">
        <h1>Błąd</h1>
        <p><?php echo htmlspecialchars($error_message); ?></p>
        <a href="home.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Powrót
        </a>
    </div>
    </div>
</body>
<?php else: ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo htmlspecialchars($film['tytuł']); ?></title>
    <link rel="stylesheet" href="styleP.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>
<body>
    <button class="back-btn" onclick="window.location.href='home.php'">
    <i class="fas fa-arrow-left"></i>
    </button>

    <div class="header">
        <div class="logo-container">
            <img src="logo.png" alt="Logo" class="logo">
        </div>
        <div class="user">
            <span><?php echo $_SESSION['nazwa_użytkownika'] ?? 'Użytkownik'; ?></span>
            <i class="fas fa-user-circle"></i>
            <a href="settings.php" class="icon-btn" data-i18n-tooltip="settings" title="Ustawienia">
                <i class="fas fa-cog"></i>
            </a>
            <a href="logout.php" class="icon-btn" data-i18n-tooltip="logout" title="Wyloguj się">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
    
    <div class="wrapper">    
        <div class="left">
            
            <div class="movie_image">
            <span class="movie_overlay"></span>
            <i class="fas fa-play"></i>
            <img src="<?php echo htmlspecialchars($film['img']); ?>" alt="Obraz filmu" />
            </div>

            
            <div class="title">
                <h2><?php echo htmlspecialchars($film['tytuł']); ?></h2>
                <span class="year">(<?php echo htmlspecialchars($film['rok'] ?? ''); ?>)</span>
            </div>
            
            <div class="movie_info">
                <span><strong>Gatunek:</strong> <?php echo htmlspecialchars($film['gatunek'] ?? 'Brak danych'); ?></span>
                <span><strong>Czas trwania:</strong> <?php echo htmlspecialchars($film['długość'] ?? ''); ?></span>
                <span><strong>Kraj produkcji:</strong> <?php echo htmlspecialchars($film['kraj'] ?? ''); ?></span>
                <span><strong>Kategoria wiekowa:</strong> <?php echo htmlspecialchars($film['kategoria_wiekowa'] ?? ''); ?></span>
            </div>
            
            <?php
            $playLinkGenerator = new Player($hasSubscription, $film['tytuł']);
            $playLink = $playLinkGenerator->getPlayLink();
            ?>
            <div class="controls">
                <a 
                    class="play-btn" 
                    target="_blank" 
                    href="<?php echo $playLink; ?>"
                > ▶ Play</a>
            </div>

        </div>

        <div class="right">
            <div class="description">
                <p><?php echo htmlspecialchars($film['opis'] ?? 'Brak opisu'); ?></p>
            </div>
            
           <div class="rate">
            <button onclick="sendRating('<?php echo addslashes($film['tytuł']); ?>', 'like')">
             <i class="fas fa-thumbs-up"></i>
            </button>
            <button onclick="sendRating('<?php echo addslashes($film['tytuł']); ?>', 'dislike')">
             <i class="fas fa-thumbs-down"></i>
            </button>
            <?php if (isset($rating)): ?>
                    <?php if ($rating['id_like'] == 1): ?>
                        <span class="liked">Liked</span>
                    <?php elseif ($rating['id_like'] == 2): ?>
                        <span class="disliked">Disliked</span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="no-rating">Brak oceny</span>
                <?php endif; ?>
            </div>
            
            <div class="comment">
                <p>Dodaj komentarz:</p>
                <textarea placeholder="Dodaj swoją opinię..."></textarea>
            </div>
        </div>
    </div>
    <script src="like.js"></script>
</body>
</html>
<?php endif; ?>
