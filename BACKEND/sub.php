<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel subskrypcji</title>

    <!-- style -->
    <link rel="stylesheet" href="styleH.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>
<body>

    <!-- przycisk powrotu -->
    <a href="settings.php" class="back-btn" data-i18n="back" title="Powrót">
        <i class="fas fa-arrow-left"></i>
    </a>

    <!-- nagłówek z logo i informacjami o użytkowniku -->
    <header>
        <img src="logo.png" alt="Streamflix Logo" class="logo" />
        <div class="user-info">
            <span class="username"><?php echo htmlspecialchars($_SESSION['nazwa_użytkownika'] ?? 'Użytkownik'); ?></span>
            <i class="fas fa-user-circle"></i>
            <a href="settings.php" class="icon-btn" data-i18n-tooltip="settings" title="Ustawienia">
                <i class="fas fa-cog"></i>
            </a>
            <a href="logout.php" class="icon-btn" data-i18n-tooltip="logout" title="Wyloguj się">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </header>

    <!-- nagłówek strony subskrypcji -->
    <h1 data-i18n="subscription">Subskrypcja <span>Streamflix</span></h1>
    <div class="subtitle" data-i18n="purchase-subscription">
        <span>Zakup subskrypcję</span>
    </div>

    <!-- wybór planów subskrypcji -->
    <div class="plans">
        <!-- plan regular -->
        <div class="plan-choice">
            <h2 data-i18n="regular-plan">Regular</h2>
            <span class="plan-icon smile"></span>
            <div class="price" data-i18n="regular-price">39.99 zł</div>
            <form action="purchase.php" method="POST">
                <input type="hidden" name="plan" value="Regular">
                <button type="submit" class="buy" data-i18n="buy">Zakup</button>
            </form>
        </div>

        <!-- plan premium -->
        <div class="plan-choice">
            <h2 data-i18n="premium-plan">Premium</h2>
            <span class="plan-icon star"></span>
            <div class="price" data-i18n="premium-price">59.99 zł</div>
            <form action="purchase.php" method="POST">
                <input type="hidden" name="plan" value="Premium">
                <button type="submit" class="buy" data-i18n="buy">Zakup</button>
            </form>
        </div>
    </div>

    <!-- skrypt odpowiedzialny za tłumaczenia i obsługę języka -->
    <script src="scriptRL.js"></script>
</body>
</html>
