<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styleRL.css" />
    <title>Streamflix - rejestracja</title>
</head>
<body>
    <!-- selektor języka -->
    <div class="language-selector">
        <select id="language">
            <option value="pl">Polski</option>
            <option value="en">English</option>
        </select>
    </div>

    <div class="container">
        <img src="logo.png" alt="Streamflix Logo" class="logo" />
        <div class="login-box">
            <h2 data-i18n="registerTitle">Rejestracja</h2>

            <!-- obsługa komunikatów sesyjnych (błędy i sukcesy) -->
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div class="error-message" data-i18n="error">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="success-message" data-i18n="success">' . htmlspecialchars($_SESSION['success']) . '</div>';
                unset($_SESSION['success']);
            }
            ?>

            <!-- formularz rejestracji -->
            <form id="registerForm" action="register.php" method="post">
                <label for="email" data-i18n="email">Email</label>
                <input type="email" id="email" name="email" required />

                <label for="username" data-i18n="username">Nazwa użytkownika</label>
                <input type="text" id="username" name="username" required />

                <label for="password" data-i18n="password">Hasło</label>
                <input type="password" id="password" name="password" required />

                <label for="confirmPassword" data-i18n="confirmPassword">Potwierdź hasło</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required />

                <label for="country" data-i18n="country">Kraj</label>
                <div class="select-country">
                    <select id="country" name="country" required>
                        <option value="pl" data-flag="PL">Polska</option>
                        <option value="us" data-flag="US">USA</option>
                        <option value="de" data-flag="DE">Germany</option>
                        <option value="fr" data-flag="FR">France</option>
                        <option value="gb" data-flag="UK">United Kingdom</option>
                    </select>
                    <span class="flag" id="flagDisplay">PL</span>
                </div>

                <button type="submit" data-i18n="registerButton">Zarejestruj się</button>

                <!-- link do logowania -->
                <p class="link">
                    <span data-i18n="toLogin">Masz już konto?</span>
                    <a href="loginSite.php">Zaloguj się</a>
                </p>
            </form>
        </div>
    </div>

    <!-- obsługa dynamicznej zmiany języka i flagi -->
    <script src="scriptRL.js"></script>
</body>
</html>
