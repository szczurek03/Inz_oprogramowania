<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="streaming, movies, series, watch online">
    <link rel="stylesheet" href="styleRL.css">
    <title>Streamflix - Logowanie</title>

</head>
<body>
    <div class="language-selector">
        <select id="language">
            <option value="pl">Polski</option>
            <option value="en">English</option>
        </select>
    </div>

    <div class="container">
        <img src="logo.png" alt="Streamflix Logo" class="logo" />
        <div class="login-box">
            <h2 data-i18n="loginTitle">Zaloguj się</h2>
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
            <form id="loginForm" method="post" action="login_process.php">
                <label data-i18n="email" for="email">Email</label>
                <input type="email" id="email" name="email" required />

                <label data-i18n="password" for="password">Hasło</label>
                <input type="password" id="password" name="password" required />

                <button data-i18n="loginButton" type="submit">Zaloguj</button>
                <p class="link" data-i18n="toRegister">Nie masz konta? <a href="register.php">Zarejestruj się</a></p>
            </form>
        </div>
    </div>

    <script src="scriptRL.js"></script>
</body>
</html>