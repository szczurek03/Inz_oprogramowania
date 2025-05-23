document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const languageSelect = document.getElementById("language");

    const translations = {
        pl: {
            loginTitle: "Zaloguj się",
            registerTitle: "Rejestracja",
            email: "Email",
            password: "Hasło",
            confirmPassword: "Potwierdź hasło",
            country: "Kraj",
            loginButton: "Zaloguj",
            registerButton: "Zarejestruj się",
            toRegister: "Nie masz konta? <a href='register.html'>Zarejestruj się</a>",
            toLogin: "Masz już konto? <a href='login.html'>Zaloguj się</a>"
        },
        en: {
            loginTitle: "Log in",
            registerTitle: "Sign up",
            email: "Email",
            password: "Password",
            confirmPassword: "Confirm password",
            country: "Country",
            loginButton: "Log in",
            registerButton: "Sign up",
            toRegister: "Don't have an account? <a href='register.html'>Sign up</a>",
            toLogin: "Already have an account? <a href='login.html'>Log in</a>"
        }
    };

    function applyTranslations(lang) {
        const elements = document.querySelectorAll("[data-i18n]");
        elements.forEach(el => {
            const key = el.getAttribute("data-i18n");
            if (translations[lang][key]) {
                if (el.tagName === "INPUT") {
                    el.placeholder = translations[lang][key];
                } else {
                    el.innerHTML = translations[lang][key];
                }
            }
        });
    }

    if (languageSelect) {
        const savedLang = localStorage.getItem("lang") || "pl";
        languageSelect.value = savedLang;
        applyTranslations(savedLang);

        languageSelect.addEventListener("change", () => {
            const selectedLang = languageSelect.value;
            localStorage.setItem("lang", selectedLang);
            applyTranslations(selectedLang);
        });
    }

    // walidacja logowania
    if (loginForm) {
        loginForm.addEventListener("submit", e => {
            e.preventDefault();
            const email = loginForm.email.value.trim();
            const password = loginForm.password.value;

            if (!validateEmail(email)) {
                alert("Nieprawidłowy adres email.");
                return;
            }
            if (password.length === 0) {
                alert("Hasło nie może być puste.");
                return;
            }

            alert("Zalogowano (symulacja).");
        });
    }

    // walidacja rejestracji
    if (registerForm) {
        registerForm.addEventListener("submit", e => {
            e.preventDefault();
            const email = registerForm.email.value.trim();
            const password = registerForm.password.value;
            const confirmPassword = registerForm.confirmPassword.value;

            if (!validateEmail(email)) {
                alert("Nieprawidłowy adres email.");
                return;
            }
            if (!validatePassword(password)) {
                alert("Hasło musi mieć min. 8 znaków, dużą i małą literę oraz cyfrę.");
                return;
            }
            if (password !== confirmPassword) {
                alert("Hasła nie są zgodne.");
                return;
            }

            alert("Rejestracja zakończona (symulacja).");
        });
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email.toLowerCase());
    }

    function validatePassword(password) {
        const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        return re.test(password);
    }

    // FLAGI
    const flagMap = {
        PL: "🇵🇱",
        US: "🇺🇸",
        DE: "🇩🇪",
        FR: "🇫🇷",
        UK: "🇬🇧"
    };

    const countrySelect = document.getElementById("country");
    const flagDisplay = document.getElementById("flagDisplay");

    function updateFlag() {
        const selectedOption = countrySelect.options[countrySelect.selectedIndex];
        const flagCode = selectedOption.getAttribute("data-flag");
        const emoji = flagMap[flagCode] || "";
        flagDisplay.textContent = emoji;
    }

    if (countrySelect && flagDisplay) {
        updateFlag(); // pokaż flagę na start
        countrySelect.addEventListener("change", updateFlag);
    }
});
