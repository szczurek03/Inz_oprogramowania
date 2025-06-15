<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8"> <!--kodowanie znaków-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--responsywność-->
    <meta name="keywords" content="streaming, movies, series, watch online"> <!--słowa kluczowe SEO-->
    <link rel="stylesheet" href="styleRL.css"> <!--dołączenie stylów-->
    <title>Streamflix - Logowanie</title>
</head>
<body>

    <!--wybór języka interfejsu-->
    <div class="language-selector">
        <select id="language">
            <option value="pl">Polski</option>
            <option value="en">English</option>
        </select>
    </div>

    <div class="container">
        <img src="logo.png" alt="Streamflix Logo" class="logo" /> <!--logo aplikacji-->
        
        <div class="login-box">
            <h2 data-i18n="loginTitle">Zaloguj się</h2>

            <?php
            session_start(); //start sesji

            //wyświetlenie komunikatu o błędzie
            if (isset($_SESSION['error'])) {
                echo '<div class="error-message" data-i18n="error">' . htmlspecialchars($_SESSION['error']) . '</div>';
                unset($_SESSION['error']);
            }

            //wyświetlenie komunikatu o sukcesie
            if (isset($_SESSION['success'])) {
                echo '<div class="success-message" data-i18n="success">' . htmlspecialchars($_SESSION['success']) . '</div>';
                unset($_SESSION['success']);
            }
            ?>

            <!--formularz logowania-->
            <form id="loginForm" method="post" action="login_process.php">
                <label data-i18n="email" for="email">Email</label>
                <input type="email" id="email" name="email" required />

                <label data-i18n="password" for="password">Hasło</label>
                <input type="password" id="password" name="password" required />

                <button data-i18n="loginButton" type="submit">Zaloguj</button>

                <!--link do rejestracji-->
                <p class="link">
                    <span data-i18n="toRegister">Nie masz konta?</span> <a href="registerSite.php">Zarejestruj się</a>
                </p>
            </form>
        </div>
    </div>

    <script src="scriptRL.js"></script> <!--skrypt JS dla języka-->
</body>
</html>
