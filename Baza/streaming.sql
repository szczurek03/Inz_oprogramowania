-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2025 at 11:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `streaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `gatunek`
--

CREATE TABLE `gatunek` (
  `id_gatunek` int(10) NOT NULL,
  `nazwa_gatunku` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gatunek`
--

INSERT INTO `gatunek` (`id_gatunek`, `nazwa_gatunku`) VALUES
(1, 'Drama'),
(2, 'Thriller'),
(3, 'Psychologiczny'),
(4, 'Kryminał'),
(5, 'Medyczny');

-- --------------------------------------------------------

--
-- Table structure for table `kategoria_wiekowa`
--

CREATE TABLE `kategoria_wiekowa` (
  `id_kategoria_wiekowa` int(10) NOT NULL,
  `nazwa_kategorii_wiekowej` varchar(255) NOT NULL COMMENT '1 = ''7'', 2 = ''PG-13'', 3 = ''R'''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategoria_wiekowa`
--

INSERT INTO `kategoria_wiekowa` (`id_kategoria_wiekowa`, `nazwa_kategorii_wiekowej`) VALUES
(1, 'R');

-- --------------------------------------------------------

--
-- Table structure for table `komentarze`
--

CREATE TABLE `komentarze` (
  `id_komentarza` int(10) NOT NULL,
  `id_użytkownika` int(10) NOT NULL,
  `id_treść` int(10) NOT NULL,
  `treść_komentarza` varchar(255) NOT NULL,
  `data_komentarza` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kraj`
--

CREATE TABLE `kraj` (
  `id_kraj` int(10) NOT NULL,
  `nazwa_kraju` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kraj`
--

INSERT INTO `kraj` (`id_kraj`, `nazwa_kraju`) VALUES
(1, 'Polska'),
(2, 'USA'),
(3, 'Wielka Brytania'),
(4, 'Niemcy');

-- --------------------------------------------------------

--
-- Table structure for table `nazwa_subskrybcji`
--

CREATE TABLE `nazwa_subskrybcji` (
  `id_nazwa_subskrybcji` int(10) NOT NULL,
  `nazwa_subskrybcji` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nazwa_subskrybcji`
--

INSERT INTO `nazwa_subskrybcji` (`id_nazwa_subskrybcji`, `nazwa_subskrybcji`) VALUES
(1, 'brak subskrypcji');

-- --------------------------------------------------------

--
-- Table structure for table `ocena`
--

CREATE TABLE `ocena` (
  `id_like` int(10) NOT NULL,
  `nazwa_oceny` varchar(255) NOT NULL COMMENT 'like/dislike'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oceny`
--

CREATE TABLE `oceny` (
  `id_oceny` int(10) NOT NULL,
  `id_użytkownika` int(10) NOT NULL,
  `id_like` int(10) NOT NULL,
  `data_oceny` date NOT NULL,
  `id_treść` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `playlisty`
--

CREATE TABLE `playlisty` (
  `id_playlisty` int(10) NOT NULL,
  `nazwa_playlisty` varchar(255) NOT NULL,
  `data_utworzenia` date NOT NULL,
  `id_użytkownika` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlisty`
--

INSERT INTO `playlisty` (`id_playlisty`, `nazwa_playlisty`, `data_utworzenia`, `id_użytkownika`) VALUES
(1, 'Przykładowa Playlista', '2025-06-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `playlisty_treści`
--

CREATE TABLE `playlisty_treści` (
  `id_playlisty` int(10) NOT NULL,
  `id_treść` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `playlisty_treści`
--

INSERT INTO `playlisty_treści` (`id_playlisty`, `id_treść`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `prośby`
--

CREATE TABLE `prośby` (
  `id_prośby` int(10) NOT NULL,
  `id_użytkownika` int(10) NOT NULL,
  `prośba` varchar(255) NOT NULL,
  `id_status_prośby` int(10) NOT NULL,
  `data_wysłania` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekomendacje`
--

CREATE TABLE `rekomendacje` (
  `id_rekomendacji` int(10) NOT NULL,
  `id_użytkownika` int(10) NOT NULL,
  `id_treść` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reżyser`
--

CREATE TABLE `reżyser` (
  `id_reżysera` int(10) NOT NULL,
  `nazwisko_reżysera` varchar(255) NOT NULL,
  `imie_reżysera` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reżyser`
--

INSERT INTO `reżyser` (`id_reżysera`, `nazwisko_reżysera`, `imie_reżysera`) VALUES
(1, 'Fincher', 'David'),
(2, 'Yaitanes', 'Greg'),
(3, 'Dahl', 'John');

-- --------------------------------------------------------

--
-- Table structure for table `status_prośby`
--

CREATE TABLE `status_prośby` (
  `id_status_prośby` int(10) NOT NULL,
  `nazwa_statusu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subskrybcja`
--

CREATE TABLE `subskrybcja` (
  `id_subskrybcji` int(10) NOT NULL,
  `id_nazwa_subskrybcji` int(10) NOT NULL,
  `data_rozpoczęcia` date NOT NULL,
  `data_zakończenia` date NOT NULL,
  `cena` float NOT NULL,
  `aktywny` int(11) NOT NULL COMMENT 'bool 1/0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subskrybcja`
--

INSERT INTO `subskrybcja` (`id_subskrybcji`, `id_nazwa_subskrybcji`, `data_rozpoczęcia`, `data_zakończenia`, `cena`, `aktywny`) VALUES
(2, 1, '1000-01-01', '1000-01-01', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `treść`
--

CREATE TABLE `treść` (
  `id_tresc` int(10) NOT NULL,
  `tytuł` varchar(255) NOT NULL,
  `opis` varchar(255) NOT NULL,
  `rok_wydania` int(4) NOT NULL,
  `data_dodania` date NOT NULL,
  `id_reżysera` int(10) NOT NULL,
  `id_kraj` int(10) NOT NULL,
  `id_kategoria_wiekowa` int(10) NOT NULL,
  `id_gatunek` int(10) NOT NULL,
  `długość` varchar(10) NOT NULL,
  `img_glowne` varchar(255) DEFAULT NULL,
  `img_mini` varchar(255) DEFAULT NULL,
  `typ` enum('film','serial') NOT NULL DEFAULT 'film'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treść`
--

INSERT INTO `treść` (`id_tresc`, `tytuł`, `opis`, `rok_wydania`, `data_dodania`, `id_reżysera`, `id_kraj`, `id_kategoria_wiekowa`, `id_gatunek`, `długość`, `img_glowne`, `img_mini`, `typ`) VALUES
(1, 'Fight Club', 'Cierpiący na bezsenność mężczyzna poznaje gardzącego konsumpcyjnym stylem życia Tylera Durdena, który jest jego zupełnym przeciwieństwem.', 1999, '2025-06-01', 1, 2, 1, 1, '139', NULL, NULL, 'film'),
(2, 'Siedem', 'Dwóch policjantów stara się złapać seryjnego mordercę wybierającego swoje ofiary według specjalnego klucza - siedmiu grzechów głównych.', 1995, '2025-06-01', 1, 2, 1, 2, '127', NULL, NULL, 'film'),
(3, 'Dr House', 'Grupa lekarzy na czele z charyzmatycznym, acz aspołecznym doktorem Housem diagnozuje nietypowe choroby, niejednokrotnie ratując życie pacjentom.', 2004, '2025-06-01', 2, 2, 1, 5, '44', NULL, NULL, 'serial'),
(4, 'Dexter', 'Dexter prowadzi podwójne życie. Za dnia jest cenionym specjalistą ds. krwi w departamencie policji, a nocą zabija złoczyńców, którzy wymykają się organom sprawiedliwości.', 2006, '2025-06-01', 3, 2, 1, 4, '53', NULL, NULL, 'serial');

-- --------------------------------------------------------

--
-- Table structure for table `treść_gatunek`
--

CREATE TABLE `treść_gatunek` (
  `id_treść` int(10) NOT NULL,
  `id_gatunek` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treść_gatunek`
--

INSERT INTO `treść_gatunek` (`id_treść`, `id_gatunek`) VALUES
(1, 1),
(1, 3),
(2, 2),
(2, 4),
(3, 5),
(3, 1),
(4, 4),
(4, 2);

-- --------------------------------------------------------

--
-- Table structure for table `użytkownicy`
--

CREATE TABLE `użytkownicy` (
  `id_użytkownika` int(10) NOT NULL,
  `nazwa_użytkownika` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hasło_hash` varchar(255) NOT NULL,
  `id_subskrybcji` int(10) NOT NULL,
  `data_założenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `użytkownicy`
--

INSERT INTO `użytkownicy` (`id_użytkownika`, `nazwa_użytkownika`, `email`, `hasło_hash`, `id_subskrybcji`, `data_założenia`) VALUES
(1, 'Test', 'test@gmail.pl', '$2y$10$OEEuq7i3AAmyOE63pvvPjeJA13g1cgdOTnj1R79uENjRdu5EQT4/q', 1, '2025-05-25'),
(3, 'ssss1233', 'dupa1233@wp.pl', '$2y$10$Dve56.jjOiEfb/x/Gb8AAOOy3VbacPLoVe9TCvBfryu3lbgHlmdJu', 1, '2025-05-25'),
(4, 'dsas', 'dupa234@wp.pl', '$2y$10$m4Vey3O5pb.6Q3X6eO42v.2uYt7R8yUFKVlJoUInlGQSIRK/7Nlum', 1, '2025-05-25'),
(5, 'DUPA', 'dupa@wp.pl', '$2y$10$/O1LN26ZTTVMoJjmK2sxUeU0fzpa6bPQQCQ/4BBXg.Cewb62XGgMa', 1, '2025-05-26'),
(6, 'dupadupa', 'dupa12345@wp.pl', '$2y$10$sxmlzX3OSDFq66cYd6EhI.YF6.OnBksHRtVEHhSV/Pqo/NIlO7y1y', 1, '2025-06-01');

-- --------------------------------------------------------

--
-- Table structure for table `użytkownicy_pracownicy`
--

CREATE TABLE `użytkownicy_pracownicy` (
  `id_użytkownika` int(10) NOT NULL,
  `nazwa_użytkownika` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `hasło_hash` varchar(255) NOT NULL,
  `data_założenia` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gatunek`
--
ALTER TABLE `gatunek`
  ADD PRIMARY KEY (`id_gatunek`);

--
-- Indexes for table `kategoria_wiekowa`
--
ALTER TABLE `kategoria_wiekowa`
  ADD PRIMARY KEY (`id_kategoria_wiekowa`);

--
-- Indexes for table `komentarze`
--
ALTER TABLE `komentarze`
  ADD PRIMARY KEY (`id_komentarza`),
  ADD KEY `FKKomentarze786489` (`id_użytkownika`);

--
-- Indexes for table `kraj`
--
ALTER TABLE `kraj`
  ADD PRIMARY KEY (`id_kraj`);

--
-- Indexes for table `nazwa_subskrybcji`
--
ALTER TABLE `nazwa_subskrybcji`
  ADD PRIMARY KEY (`id_nazwa_subskrybcji`);

--
-- Indexes for table `ocena`
--
ALTER TABLE `ocena`
  ADD PRIMARY KEY (`id_like`);

--
-- Indexes for table `oceny`
--
ALTER TABLE `oceny`
  ADD PRIMARY KEY (`id_oceny`),
  ADD KEY `FKOceny277245` (`id_użytkownika`),
  ADD KEY `FKOceny22990` (`id_treść`),
  ADD KEY `FKOceny797359` (`id_like`);

--
-- Indexes for table `playlisty`
--
ALTER TABLE `playlisty`
  ADD PRIMARY KEY (`id_playlisty`),
  ADD KEY `FKPlaylisty145396` (`id_użytkownika`);

--
-- Indexes for table `playlisty_treści`
--
ALTER TABLE `playlisty_treści`
  ADD PRIMARY KEY (`id_playlisty`,`id_treść`) USING BTREE,
  ADD KEY `FKPlaylisty_104558` (`id_treść`);

--
-- Indexes for table `prośby`
--
ALTER TABLE `prośby`
  ADD PRIMARY KEY (`id_prośby`),
  ADD KEY `FKProśby973918` (`id_użytkownika`),
  ADD KEY `FKProśby816653` (`id_status_prośby`);

--
-- Indexes for table `rekomendacje`
--
ALTER TABLE `rekomendacje`
  ADD PRIMARY KEY (`id_rekomendacji`),
  ADD KEY `FKRekomendac916800` (`id_użytkownika`),
  ADD KEY `FKRekomendac171056` (`id_treść`);

--
-- Indexes for table `reżyser`
--
ALTER TABLE `reżyser`
  ADD PRIMARY KEY (`id_reżysera`);

--
-- Indexes for table `status_prośby`
--
ALTER TABLE `status_prośby`
  ADD PRIMARY KEY (`id_status_prośby`);

--
-- Indexes for table `subskrybcja`
--
ALTER TABLE `subskrybcja`
  ADD PRIMARY KEY (`id_subskrybcji`),
  ADD KEY `FKSubskrybcj736405` (`id_nazwa_subskrybcji`);

--
-- Indexes for table `treść`
--
ALTER TABLE `treść`
  ADD PRIMARY KEY (`id_tresc`),
  ADD KEY `FKTreść429407` (`id_kraj`),
  ADD KEY `FKTreść44637` (`id_kategoria_wiekowa`),
  ADD KEY `FKTreść509063` (`id_gatunek`),
  ADD KEY `FKTreść294769` (`id_reżysera`);

--
-- Indexes for table `treść_gatunek`
--
ALTER TABLE `treść_gatunek`
  ADD KEY `FKTreść_gatu826010` (`id_gatunek`),
  ADD KEY `FKTreść_gatu732026` (`id_treść`);

--
-- Indexes for table `użytkownicy`
--
ALTER TABLE `użytkownicy`
  ADD PRIMARY KEY (`id_użytkownika`);

--
-- Indexes for table `użytkownicy_pracownicy`
--
ALTER TABLE `użytkownicy_pracownicy`
  ADD PRIMARY KEY (`id_użytkownika`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gatunek`
--
ALTER TABLE `gatunek`
  MODIFY `id_gatunek` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `kategoria_wiekowa`
--
ALTER TABLE `kategoria_wiekowa`
  MODIFY `id_kategoria_wiekowa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `komentarze`
--
ALTER TABLE `komentarze`
  MODIFY `id_komentarza` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kraj`
--
ALTER TABLE `kraj`
  MODIFY `id_kraj` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `nazwa_subskrybcji`
--
ALTER TABLE `nazwa_subskrybcji`
  MODIFY `id_nazwa_subskrybcji` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ocena`
--
ALTER TABLE `ocena`
  MODIFY `id_like` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oceny`
--
ALTER TABLE `oceny`
  MODIFY `id_oceny` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `playlisty`
--
ALTER TABLE `playlisty`
  MODIFY `id_playlisty` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `prośby`
--
ALTER TABLE `prośby`
  MODIFY `id_prośby` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekomendacje`
--
ALTER TABLE `rekomendacje`
  MODIFY `id_rekomendacji` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reżyser`
--
ALTER TABLE `reżyser`
  MODIFY `id_reżysera` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `status_prośby`
--
ALTER TABLE `status_prośby`
  MODIFY `id_status_prośby` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subskrybcja`
--
ALTER TABLE `subskrybcja`
  MODIFY `id_subskrybcji` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `treść`
--
ALTER TABLE `treść`
  MODIFY `id_tresc` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `użytkownicy`
--
ALTER TABLE `użytkownicy`
  MODIFY `id_użytkownika` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `użytkownicy_pracownicy`
--
ALTER TABLE `użytkownicy_pracownicy`
  MODIFY `id_użytkownika` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentarze`
--
ALTER TABLE `komentarze`
  ADD CONSTRAINT `FKKomentarze786489` FOREIGN KEY (`id_użytkownika`) REFERENCES `użytkownicy` (`id_użytkownika`);

--
-- Constraints for table `oceny`
--
ALTER TABLE `oceny`
  ADD CONSTRAINT `FKOceny22990` FOREIGN KEY (`id_treść`) REFERENCES `treść` (`id_tresc`),
  ADD CONSTRAINT `FKOceny277245` FOREIGN KEY (`id_użytkownika`) REFERENCES `użytkownicy` (`id_użytkownika`),
  ADD CONSTRAINT `FKOceny797359` FOREIGN KEY (`id_like`) REFERENCES `ocena` (`id_like`);

--
-- Constraints for table `playlisty`
--
ALTER TABLE `playlisty`
  ADD CONSTRAINT `FKPlaylisty145396` FOREIGN KEY (`id_użytkownika`) REFERENCES `użytkownicy` (`id_użytkownika`);

--
-- Constraints for table `playlisty_treści`
--
ALTER TABLE `playlisty_treści`
  ADD CONSTRAINT `FKPlaylisty_104558` FOREIGN KEY (`id_treść`) REFERENCES `treść` (`id_tresc`),
  ADD CONSTRAINT `FKPlaylisty_663861` FOREIGN KEY (`id_playlisty`) REFERENCES `playlisty` (`id_playlisty`);

--
-- Constraints for table `prośby`
--
ALTER TABLE `prośby`
  ADD CONSTRAINT `FKProśby816653` FOREIGN KEY (`id_status_prośby`) REFERENCES `status_prośby` (`id_status_prośby`),
  ADD CONSTRAINT `FKProśby973918` FOREIGN KEY (`id_użytkownika`) REFERENCES `użytkownicy` (`id_użytkownika`);

--
-- Constraints for table `rekomendacje`
--
ALTER TABLE `rekomendacje`
  ADD CONSTRAINT `FKRekomendac171056` FOREIGN KEY (`id_treść`) REFERENCES `treść` (`id_tresc`),
  ADD CONSTRAINT `FKRekomendac916800` FOREIGN KEY (`id_użytkownika`) REFERENCES `użytkownicy` (`id_użytkownika`);

--
-- Constraints for table `subskrybcja`
--
ALTER TABLE `subskrybcja`
  ADD CONSTRAINT `FKSubskrybcj736405` FOREIGN KEY (`id_nazwa_subskrybcji`) REFERENCES `nazwa_subskrybcji` (`id_nazwa_subskrybcji`);

--
-- Constraints for table `treść`
--
ALTER TABLE `treść`
  ADD CONSTRAINT `FKTreść294769` FOREIGN KEY (`id_reżysera`) REFERENCES `reżyser` (`id_reżysera`),
  ADD CONSTRAINT `FKTreść429407` FOREIGN KEY (`id_kraj`) REFERENCES `kraj` (`id_kraj`),
  ADD CONSTRAINT `FKTreść44637` FOREIGN KEY (`id_kategoria_wiekowa`) REFERENCES `kategoria_wiekowa` (`id_kategoria_wiekowa`),
  ADD CONSTRAINT `FKTreść509063` FOREIGN KEY (`id_gatunek`) REFERENCES `gatunek` (`id_gatunek`);

--
-- Constraints for table `treść_gatunek`
--
ALTER TABLE `treść_gatunek`
  ADD CONSTRAINT `FKTreść_gatu732026` FOREIGN KEY (`id_treść`) REFERENCES `treść` (`id_tresc`),
  ADD CONSTRAINT `FKTreść_gatu826010` FOREIGN KEY (`id_gatunek`) REFERENCES `gatunek` (`id_gatunek`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
