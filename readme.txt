# StreamFlix

**StreamFlix** to nowoczesna platforma do streamingu wideo działająca w modelu subskrypcyjnym VOD (Video on Demand). Umożliwia oglądanie filmów i seriali, ocenianie ich oraz personalizację rekomendacji na podstawie historii aktywności użytkownika.

---

## Opis projektu

Celem platformy jest zwiększenie lojalności użytkowników oraz wydłużenie czasu spędzanego na oglądaniu treści. System oferuje:

- spersonalizowane rekomendacje,
- szybki dostęp do treści poprzez krótkie klipy promujące pełne wersje filmów,
- możliwość wysyłania próśb o nowe treści,
- ochronę treści przed nieautoryzowanym kopiowaniem,
- panel twórcy i administratora do zarządzania licencjami i filmami.

---
## Technologie

| Technologia         | Wersja           | Uzasadnienie wyboru                                                       |
|---------------------|------------------|---------------------------------------------------------------------------|
| HTML                | HTML5            | Struktura dokumentów oraz dynamiczne ładowanie treści                     |
| CSS                 | CSS3             | Stylowanie elementów interfejsu i responsywność aplikacji                 |
| JavaScript          | ES6              | Obsługa interakcji, walidacja, dynamiczne komponenty                      |
| PHP                 | 8.0.30           | Obsługa logiki aplikacji po stronie serwera, zgodność z Composer i XAMPP  |
| Composer            | 2.8.9            | Zarządzanie zależnościami i testami w PHP                                 |
| MariaDB (MySQL)     | 10.4.32          | Kompatybilna z MySQL, wykorzystywana do przechowywania danych             |
| XAMPP               | 3.3.0            | Lokalne środowisko serwerowe: Apache, PHP, MariaDB, phpMyAdmin            |
| PHPUnit             | 9.5.0            | Popularne narzędzie do pisania testów jednostkowych w PHP, wspierane przez|
|		      |		         | Composer i dobrze zintegrowane z projektami PHP			     |	
---

## Główne funkcjonalności

- Logowanie i rejestracja użytkowników  
- Wysyłanie próśb o dodanie brakujących filmów  
- Odtwarzanie filmów i seriali z poziomu przeglądarki  
- Zarządzanie subskrypcją (zakup, anulowanie)  
- Dodawanie komentarzy i ocena treści  
- System rekomendacji filmów na podstawie listy życzeń  

---

## Struktura katalogów projektu
StreamFlix/
├── BACKEND/
│ ├── miniaturki/
│ ├── tests/
│ ├── composer.json
│ ├── composer.lock
│ ├── hash
│ ├── home
│ ├── homepage
│ ├── info
│ ├── like
│ ├── like.js
│ ├── login
│ ├── loginconnect
│ ├── loginSite
│ ├── logo
│ ├── logout
│ ├── logout_functions
│ ├── movie_preview
│ ├── Player
│ ├── purchase
│ ├── register
│ ├── registerSite
│ ├── script.js
│ ├── scriptRL.js
│ ├── settings
│ ├── styleH
│ ├── styleP
│ ├── styleRL
│ ├── sub
│ ├── UserAuth
│ └── UserRegister
│
├── Baza/
├── HomepageFrontend/
├── Login/
├── Movie Preview FrontEnd/
├── Streamflix register and login/
├── Subscription/
├── styleH
├── opis
├── .gitignore

## Autorzy 

- Klaudia Krawiec
- Martyna Jabłońska
- Aleksandra Czereszkiewicz

---

## Licencja

Projekt edukacyjny – brak licencji komercyjnej.

