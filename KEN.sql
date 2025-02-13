-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Lis 14, 2023 at 07:17 AM
-- Wersja serwera: 10.11.4-MariaDB-1~deb12u1
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `KEN`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `efekt_uczniowie_do_oceny`
--

CREATE TABLE `efekt_uczniowie_do_oceny` (
  `id_ucznia` int(11) NOT NULL,
  `rok` int(20) NOT NULL,
  `semestr` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `efekt_uczniowie_do_oceny`
--

INSERT INTO `efekt_uczniowie_do_oceny` (`id_ucznia`, `rok`, `semestr`) VALUES
(1, 2022, 'drugi'),
(5, 2022, 'drugi'),
(25, 2022, 'drugi'),
(28, 2022, 'drugi'),
(30, 2022, 'drugi'),
(34, 2022, 'drugi'),
(35, 2022, 'drugi'),
(40, 2022, 'drugi'),
(46, 2022, 'drugi'),
(67, 2022, 'drugi'),
(76, 2022, 'drugi'),
(81, 2022, 'drugi'),
(99, 2022, 'drugi'),
(100, 2022, 'drugi'),
(122, 2022, 'drugi'),
(124, 2022, 'drugi'),
(126, 2022, 'drugi'),
(162, 2022, 'drugi'),
(172, 2022, 'drugi'),
(175, 2022, 'drugi'),
(204, 2022, 'drugi'),
(237, 2022, 'drugi'),
(250, 2022, 'drugi'),
(251, 2022, 'drugi'),
(263, 2022, 'drugi'),
(268, 2022, 'drugi'),
(269, 2022, 'drugi'),
(273, 2022, 'drugi'),
(276, 2022, 'drugi'),
(279, 2022, 'drugi'),
(312, 2022, 'drugi'),
(317, 2022, 'drugi'),
(338, 2022, 'drugi'),
(339, 2022, 'drugi'),
(341, 2022, 'drugi'),
(352, 2022, 'drugi'),
(361, 2022, 'drugi'),
(367, 2022, 'drugi'),
(380, 2022, 'drugi'),
(384, 2022, 'drugi'),
(386, 2022, 'drugi'),
(391, 2022, 'drugi'),
(395, 2022, 'drugi'),
(403, 2022, 'drugi'),
(405, 2022, 'drugi'),
(409, 2022, 'drugi'),
(421, 2022, 'drugi'),
(424, 2022, 'drugi'),
(443, 2022, 'drugi'),
(460, 2022, 'drugi'),
(465, 2022, 'drugi'),
(471, 2022, 'drugi'),
(498, 2022, 'drugi'),
(499, 2022, 'drugi'),
(500, 2022, 'drugi'),
(501, 2022, 'drugi'),
(503, 2022, 'drugi'),
(505, 2022, 'drugi'),
(518, 2022, 'drugi'),
(519, 2022, 'drugi'),
(537, 2022, 'drugi'),
(538, 2022, 'drugi'),
(549, 2022, 'drugi'),
(590, 2022, 'drugi'),
(597, 2022, 'drugi'),
(600, 2022, 'drugi'),
(607, 2022, 'drugi'),
(612, 2022, 'drugi'),
(619, 2022, 'drugi'),
(625, 2022, 'drugi'),
(635, 2022, 'drugi'),
(636, 2022, 'drugi'),
(637, 2022, 'drugi'),
(649, 2022, 'drugi'),
(660, 2022, 'drugi'),
(680, 2022, 'drugi'),
(682, 2022, 'drugi'),
(692, 2022, 'drugi'),
(697, 2022, 'drugi'),
(707, 2022, 'drugi'),
(714, 2022, 'drugi');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_AktywnyOkres`
--

CREATE TABLE `godz_AktywnyOkres` (
  `ID_OkresRozliczeniowy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_Nauczyciele_Godziny`
--

CREATE TABLE `godz_Nauczyciele_Godziny` (
  `ID` int(11) NOT NULL,
  `ID_Nauczyciela` int(11) NOT NULL,
  `rokSzk` int(11) NOT NULL,
  `miesiac` varchar(30) NOT NULL,
  `PN` int(11) NOT NULL,
  `WT` int(11) NOT NULL,
  `SR` int(11) NOT NULL,
  `CZ` int(11) NOT NULL,
  `PT` int(11) NOT NULL,
  `kl4` int(11) NOT NULL,
  `etat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `godz_Nauczyciele_Godziny`
--

INSERT INTO `godz_Nauczyciele_Godziny` (`ID`, `ID_Nauczyciela`, `rokSzk`, `miesiac`, `PN`, `WT`, `SR`, `CZ`, `PT`, `kl4`, `etat`) VALUES
(3, 13, 2023, 'wrzesień', 5, 5, 7, 3, 1, 7, 18),
(4, 13, 2023, 'październik', 5, 5, 7, 3, 1, 7, 18),
(5, 11, 2023, 'wrzesień', 5, 5, 5, 5, 5, 5, 18),
(6, 9, 2023, 'wrzesień', 3, 4, 5, 2, 7, 6, 18),
(7, 1, 2023, 'wrzesień', 3, 4, 5, 5, 4, 5, 18),
(8, 3, 2023, 'wrzesień', 4, 5, 5, 4, 6, 4, 18),
(9, 1, 2023, 'październik', 3, 4, 5, 4, 4, 5, 18),
(10, 14, 2023, 'wrzesień', 2, 2, 5, 6, 4, 2, 18),
(11, 52, 2023, 'październik', 5, 2, 3, 3, 0, 2, 18);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_Nauczyciele_klasy4`
--

CREATE TABLE `godz_Nauczyciele_klasy4` (
  `id` int(11) NOT NULL,
  `id_Nauczyciela` int(11) NOT NULL,
  `miesiac` varchar(20) NOT NULL,
  `rokSzk` int(11) NOT NULL,
  `odpracowane` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `godz_Nauczyciele_klasy4`
--

INSERT INTO `godz_Nauczyciele_klasy4` (`id`, `id_Nauczyciela`, `miesiac`, `rokSzk`, `odpracowane`) VALUES
(6, 1, 'październik', 2023, 8),
(8, 13, 'październik', 2023, 12),
(9, 13, 'wrzesień', 2023, 8);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_Nauczyciele_Nadgodziny`
--

CREATE TABLE `godz_Nauczyciele_Nadgodziny` (
  `ID` int(11) NOT NULL,
  `ID_Nauczyciela` int(11) NOT NULL,
  `id_tydzien` int(11) NOT NULL,
  `dzien` int(11) NOT NULL,
  `wolne` varchar(20) DEFAULT NULL,
  `dorazne` int(11) NOT NULL DEFAULT 0,
  `indywidualne` int(11) NOT NULL DEFAULT 0,
  `inne` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `godz_Nauczyciele_Nadgodziny`
--

INSERT INTO `godz_Nauczyciele_Nadgodziny` (`ID`, `ID_Nauczyciela`, `id_tydzien`, `dzien`, `wolne`, `dorazne`, `indywidualne`, `inne`) VALUES
(157, 13, 9, 0, '', 0, 0, 0),
(158, 13, 9, 1, '', 0, 0, 0),
(159, 13, 9, 2, '', 0, 0, 0),
(160, 13, 9, 3, 'l4', 0, 0, 0),
(161, 13, 9, 4, '', 0, 0, 0),
(162, 13, 10, 0, '', 0, 0, 0),
(163, 13, 10, 1, '', 0, 0, 0),
(164, 13, 10, 2, 'u', 0, 0, 0),
(165, 13, 10, 3, '', 0, 1, 0),
(166, 13, 10, 4, '', 0, 1, 0),
(167, 13, 11, 0, '', 0, 0, 0),
(168, 13, 11, 1, '', 0, 0, 0),
(169, 13, 11, 2, '', 0, 0, 0),
(170, 13, 11, 3, '', 0, 0, 0),
(171, 13, 11, 4, '', 0, 0, 0),
(593, 13, 48, 0, '', 0, 0, 0),
(594, 13, 48, 1, '', 0, 0, 0),
(595, 13, 48, 2, '', 0, 0, 0),
(596, 13, 48, 3, '', 0, 1, 0),
(597, 13, 48, 4, '', 0, 0, 0),
(598, 13, 49, 0, '', 0, 0, 0),
(599, 13, 49, 1, '', 0, 0, 0),
(600, 13, 49, 2, '', 0, 0, 1),
(601, 13, 49, 3, '', 3, 1, 0),
(602, 13, 49, 4, '', 0, 0, 0),
(603, 13, 50, 0, '', 0, 0, 0),
(604, 13, 50, 1, '', 0, 0, 0),
(605, 13, 50, 2, '', 0, 0, 0),
(606, 13, 50, 3, '', 0, 0, 0),
(607, 13, 50, 4, '', 0, 0, 0),
(608, 13, 51, 0, '', 0, 0, 0),
(609, 13, 51, 1, '', 0, 0, 0),
(610, 13, 51, 2, '', 0, 0, 0),
(611, 13, 51, 3, '', 0, 0, 0),
(612, 13, 51, 4, '', 0, 0, 0),
(613, 13, 48, 0, '', 0, 0, 0),
(614, 13, 48, 1, '', 1, 1, 0),
(615, 13, 48, 2, '', 0, 0, 0),
(616, 13, 48, 3, '', 0, 0, 0),
(617, 13, 48, 4, '', 0, 0, 0),
(618, 13, 48, 0, '', 0, 0, 0),
(619, 13, 48, 1, '', 1, 1, 0),
(620, 13, 48, 2, '', 0, 0, 0),
(621, 13, 48, 3, '', 0, 0, 0),
(622, 13, 48, 4, '', 0, 0, 0),
(623, 13, 48, 0, '', 0, 0, 0),
(624, 13, 48, 1, '', 1, 1, 0),
(625, 13, 48, 2, '', 1, 0, 0),
(626, 13, 48, 3, '', 0, 0, 0),
(627, 13, 48, 4, '', 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_Nauczyciele_Rozliczenie_Tydzien`
--

CREATE TABLE `godz_Nauczyciele_Rozliczenie_Tydzien` (
  `ID_rozliczenia` int(11) NOT NULL,
  `id_tydzien` int(11) DEFAULT NULL,
  `miesiac` varchar(20) NOT NULL,
  `rokSzk` int(11) NOT NULL,
  `id_nauczyciel` int(11) DEFAULT NULL,
  `D1_wolne` varchar(20) DEFAULT NULL,
  `D1_dorazne` int(11) DEFAULT NULL,
  `D1_indyw` int(11) DEFAULT NULL,
  `D1_inne` int(11) DEFAULT NULL,
  `D2_wolne` varchar(20) DEFAULT NULL,
  `D2_dorazne` int(11) DEFAULT NULL,
  `D2_indyw` int(11) DEFAULT NULL,
  `D2_inne` int(11) DEFAULT NULL,
  `D3_wolne` varchar(20) DEFAULT NULL,
  `D3_dorazne` int(11) DEFAULT NULL,
  `D3_indyw` int(11) DEFAULT NULL,
  `D3_inne` int(11) DEFAULT NULL,
  `D4_wolne` varchar(20) DEFAULT NULL,
  `D4_dorazne` int(11) DEFAULT NULL,
  `D4_indyw` int(11) DEFAULT NULL,
  `D4_inne` int(11) DEFAULT NULL,
  `D5_wolne` varchar(20) DEFAULT NULL,
  `D5_dorazne` int(11) DEFAULT NULL,
  `D5_indyw` int(11) DEFAULT NULL,
  `D5_inne` int(11) DEFAULT NULL,
  `razem_nadgodz` int(11) DEFAULT NULL,
  `razem_dorazne` int(11) DEFAULT NULL,
  `razem_indyw` int(11) DEFAULT NULL,
  `razem_inne` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `godz_Nauczyciele_Rozliczenie_Tydzien`
--

INSERT INTO `godz_Nauczyciele_Rozliczenie_Tydzien` (`ID_rozliczenia`, `id_tydzien`, `miesiac`, `rokSzk`, `id_nauczyciel`, `D1_wolne`, `D1_dorazne`, `D1_indyw`, `D1_inne`, `D2_wolne`, `D2_dorazne`, `D2_indyw`, `D2_inne`, `D3_wolne`, `D3_dorazne`, `D3_indyw`, `D3_inne`, `D4_wolne`, `D4_dorazne`, `D4_indyw`, `D4_inne`, `D5_wolne`, `D5_dorazne`, `D5_indyw`, `D5_inne`, `razem_nadgodz`, `razem_dorazne`, `razem_indyw`, `razem_inne`) VALUES
(7, 48, 'październik', 2023, 13, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 1, 0, '', 0, 0, 0, 3, 0, 1, 0),
(8, 49, 'październik', 2023, 13, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 3, 0, 0, 0),
(9, 50, 'październik', 2023, 13, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 3, 0, 0, 0),
(10, 51, 'październik', 2023, 13, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 3, 0, 0, 0),
(21, 48, 'październik', 2023, 1, '', 0, 0, 0, 'o', 0, 0, 0, '', 2, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 2, 2, 0, 0),
(22, 49, 'październik', 2023, 1, '', 0, 0, 0, '', 0, 0, 0, '', 0, 1, 0, '', 0, 0, 0, '', 0, 0, 0, 2, 0, 1, 0),
(23, 50, 'październik', 2023, 1, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 2, 0, 0, 0),
(24, 51, 'październik', 2023, 1, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 2, 0, 0, 0),
(25, 9, 'wrzesień', 2023, 13, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 2, 0, 0, 0),
(26, 10, 'wrzesień', 2023, 13, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 3, 0, 0, 0),
(27, 11, 'wrzesień', 2023, 13, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 3, 0, 0, 0),
(28, 9, 'wrzesień', 2023, 11, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 6, 0, 0, 0),
(29, 10, 'wrzesień', 2023, 11, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 7, 0, 0, 0),
(30, 11, 'wrzesień', 2023, 11, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 7, 0, 0, 0),
(34, 9, 'wrzesień', 2023, 14, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 1, 0, 0, 0),
(35, 10, 'wrzesień', 2023, 14, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 1, 0, 0, 0),
(36, 11, 'wrzesień', 2023, 14, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 1, 0, 0, 0),
(37, 48, 'październik', 2023, 14, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 1, 0, 0, 0),
(38, 49, 'październik', 2023, 14, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 1, 0, 0, 0),
(39, 50, 'październik', 2023, 14, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 1, 0, 0, 0),
(40, 51, 'październik', 2023, 14, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, '', 0, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_Nauczyciele_Tydzien_old`
--

CREATE TABLE `godz_Nauczyciele_Tydzien_old` (
  `id` int(11) NOT NULL,
  `id_Nauczyciela` int(11) NOT NULL,
  `id_Tydzien` int(11) NOT NULL,
  `RazemNadgodziny` int(11) NOT NULL,
  `RazemDorazne` int(11) NOT NULL,
  `RazemIndyw` int(11) NOT NULL,
  `RazemInne` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_okresRozliczeniowy`
--

CREATE TABLE `godz_okresRozliczeniowy` (
  `ID` int(11) NOT NULL,
  `rokSzk` int(11) NOT NULL,
  `miesiac` varchar(20) NOT NULL,
  `tydzien_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_passwords`
--

CREATE TABLE `godz_passwords` (
  `typKonta` varchar(30) NOT NULL,
  `haslo` varchar(128) NOT NULL,
  `first_login` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `godz_passwords`
--

INSERT INTO `godz_passwords` (`typKonta`, `haslo`, `first_login`) VALUES
('Dyrektor', '$argon2i$v=19$m=65536,t=4,p=1$MlVKZG9VQ2VHNDEzWHAuWQ$OryFE7icfJjpbYS+tgode1XstF07uch8DRPYN3ae7XU', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `godz_TydzienRozliczeniowy`
--

CREATE TABLE `godz_TydzienRozliczeniowy` (
  `ID` int(11) NOT NULL,
  `rokSzk` int(11) NOT NULL,
  `miesiac` varchar(30) NOT NULL,
  `DataPoczatkowa` date NOT NULL,
  `D1` tinyint(1) NOT NULL DEFAULT 0,
  `D2` tinyint(1) NOT NULL DEFAULT 0,
  `D3` tinyint(1) NOT NULL DEFAULT 0,
  `D4` tinyint(1) NOT NULL DEFAULT 0,
  `D5` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `godz_TydzienRozliczeniowy`
--

INSERT INTO `godz_TydzienRozliczeniowy` (`ID`, `rokSzk`, `miesiac`, `DataPoczatkowa`, `D1`, `D2`, `D3`, `D4`, `D5`) VALUES
(9, 2023, 'wrzesień', '2023-09-04', 1, 0, 0, 0, 0),
(10, 2023, 'wrzesień', '2023-09-11', 0, 0, 0, 0, 0),
(11, 2023, 'wrzesień', '2023-09-18', 0, 0, 0, 0, 0),
(48, 2023, 'październik', '2023-09-25', 0, 0, 0, 0, 0),
(49, 2023, 'październik', '2023-10-02', 0, 0, 0, 0, 0),
(50, 2023, 'październik', '2023-10-09', 0, 0, 0, 0, 0),
(51, 2023, 'październik', '2023-10-16', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `miesiace`
--

CREATE TABLE `miesiace` (
  `miesiac` varchar(20) NOT NULL,
  `nr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `miesiace`
--

INSERT INTO `miesiace` (`miesiac`, `nr`) VALUES
('Czerwiec', 10),
('Grudzień', 4),
('Kwiecień', 8),
('Listopad', 3),
('Luty', 6),
('Maj', 9),
('Marzec', 7),
('Październik', 2),
('Styczeń', 5),
('Wrzesień', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nagrody_typ`
--

CREATE TABLE `nagrody_typ` (
  `id` int(11) NOT NULL,
  `typ` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nagrody_typ`
--

INSERT INTO `nagrody_typ` (`id`, `typ`) VALUES
(1, 'wzorowe zachowanie'),
(2, 'bardzo dobre zachowanie'),
(3, 'bardzo dobre wyniki w nauce'),
(4, 'wzorową frekwencję'),
(5, 'zaangażowanie w pracę na rzecz klasy'),
(6, 'zaangażowanie w pracę na rzecz szkoły'),
(7, 'reprezentowanie szkoły w konkursach'),
(8, 'reprezentowanie szkoły w olimpiadach');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nagrody_wpisy`
--

CREATE TABLE `nagrody_wpisy` (
  `id` int(11) NOT NULL,
  `id_nauczyciela` int(11) NOT NULL,
  `dla_kogo` varchar(100) NOT NULL,
  `tekst_nagrody` varchar(255) NOT NULL,
  `rok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nagrody_wpisy`
--

INSERT INTO `nagrody_wpisy` (`id`, `id_nauczyciela`, `dla_kogo`, `tekst_nagrody`, `rok`) VALUES
(11, 13, 'Jana Nowaka', 'bardzo dobre zachowanie, bardzo dobre wyniki w nauce oraz zaangażowanie w pracę na rzecz klasy', 2023),
(12, 13, 'Aliny Kowalskiej', 'wzorowe zachowanie, bardzo dobre wyniki w nauce, zaangażowanie w pracę na rzecz szkoły oraz reprezentowanie szkoły w konkursach', 2023);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Nauczyciele`
--

CREATE TABLE `Nauczyciele` (
  `ID` int(11) NOT NULL,
  `Nazwisko` varchar(30) NOT NULL,
  `Imie` varchar(30) NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `first_login` tinyint(1) NOT NULL DEFAULT 1,
  `email` varchar(30) NOT NULL,
  `aktywne` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Nauczyciele`
--

INSERT INTO `Nauczyciele` (`ID`, `Nazwisko`, `Imie`, `haslo`, `first_login`, `email`, `aktywne`) VALUES
(1, 'Adamczyk-Jóskow', 'Lidia', '$argon2i$v=19$m=65536,t=4,p=1$S09xemlwZm1DQzlTUEJaMA$YuQ5bp7D/gP/qVPLVIBnm0Aqxmq3FkI20AnUOYRBJ1I', 1, '', 0),
(2, 'Antolak', 'Beata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 0, '', 1),
(3, 'Biel', 'Damian', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(4, 'Bogusz', 'Piotr', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(5, 'Budzyńska', 'Jolanta', '$argon2i$v=19$m=65536,t=4,p=1$eGVkT2dwMFlodEFjUVB6OA$5OWKU3W7Qud3quhsY1kQFIA6vYxtCv6KBRUpUh8epRA', 1, '', 1),
(6, 'Castillo-Żarczyński', 'Luz', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(7, 'Chyla', 'Anna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(8, 'Cichowlaz', 'Zofia', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(9, 'Cieślicka', 'Katarzyna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(10, 'Dejer', 'Jarosław', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(11, 'Dębska', 'Maria', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(12, 'Filip-Rękawek', 'Anna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(13, 'Frączkiewicz', 'Dariusz', '$2y$10$28CCBE7i5jOah9ygnzQC..WQcaJ27YKtH.yVBw3F4FNMsA4hKtEUC', 0, 'dafr32@gmail.com', 1),
(14, 'Gąsiorek', 'Katarzyna', '$argon2i$v=19$m=65536,t=4,p=1$Y2wvY3BjSjk2TjhGNTZ6Wg$Y1M4B3OSa45Sjiq03adMuZIbiHchjs0E98CE2QT5c+g', 0, '', 1),
(15, 'Goliasz', 'Renata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(16, 'Gołąb', 'Kinga', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(17, 'Handzlik', 'Anna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(18, 'Jarosz', 'Katarzyna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(19, 'Jarosz', 'Wojciech', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(20, 'Jędrusiak-Malec', 'Agnieszka', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(21, 'Jonik', 'Mieczysław', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(22, 'Kalabińska', 'Beata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(23, 'Kazała', 'Adam', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(24, 'Klos-Furgała', 'Sylwia', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(25, 'Kłoda', 'Lidia', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(26, 'Kosma-Drwięga', 'Sabina', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(27, 'Kostka', 'Bogumił', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(28, 'Kowaliczek', 'Grzegorz', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(29, 'Krańczuk', 'Ewa', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(30, 'Kwaśna', 'Renata', '$argon2i$v=19$m=65536,t=4,p=1$ZlFvSVIvc2dIZ0Ezek1zOA$wd1EHEUKNAWb/qz9bM1ARvRj/8HuTeMULVNScYZFeZw', 1, '', 1),
(31, 'Lesiak-Linnert', 'Magdalena', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(32, 'Ludwig-Jawura', 'Anna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(33, 'Małyszko', 'Krystyna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(34, 'Marek', 'Dorota', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(35, 'Marek', 'Monika', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(36, 'Marekwica', 'Agnieszka', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(37, 'Maślanka', 'Renata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(38, 'Michalec', 'Małgorzata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(39, 'Nycz', 'Maciej', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(40, 'Oświęcimska', 'Janina', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(41, 'Pala', 'Lilla', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(42, 'Pawłowska', 'Magdalena', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(43, 'Piszcz', 'Łukasz', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(44, 'Rączka', 'Krzysztof', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(45, 'Rusin', 'Piotr', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(46, 'Sachajko-Polke', 'Aleksandra', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(47, 'Saletnik', 'Maria', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(48, 'Saletnik', 'Władysław', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(49, 'Sapeta', 'Mirosław', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(50, 'Sierek', 'Mirella', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(51, 'Sitek', 'Bartosz', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(52, 'Stasica', 'Marzena', '$argon2i$v=19$m=65536,t=4,p=1$MmxxV3JsemdUVjZ1SmhCRA$YukWD3Z6pG9IaMhnEIFtbBBQx8mbwJS4KvbDfTIt+4M', 0, '', 1),
(53, 'Stawarczyk', 'Paweł', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(54, 'Szczerska', 'Ewa', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(55, 'Szczotka', 'Anna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(56, 'Szczotka', 'Beata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(57, 'Szczotka', 'Katarzyna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(58, 'Szubert', 'Agata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(59, 'Tomaszek', 'Magdalena', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(60, 'Wolff', 'Joanna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(61, 'Wranik', 'Mirosław', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(62, 'Wróbel', 'Beata', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(63, 'Zagrobelna', 'Joanna', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1),
(64, 'Zawadzka', 'Urszula', '$argon2i$v=19$m=65536,t=4,p=1$Ym1LZmN0UHZwenJFMHAuLg$x2eI8mCdvgXq5Hf213UC0lCoGf6v31SttHJUia3e5Gw', 1, '', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Przedmioty`
--

CREATE TABLE `Przedmioty` (
  `przedmiot` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Przedmioty`
--

INSERT INTO `Przedmioty` (`przedmiot`) VALUES
('biologia'),
('chemia'),
('filozofia'),
('fizyka'),
('geografia'),
('historia'),
('historia i teraźniejszość'),
('informatyka'),
('język angielski'),
('język hiszpański'),
('język niemiecki'),
('język polski'),
('język rosyjski'),
('język włoski'),
('język łaciński i kultura antyczna'),
('matematyka'),
('podstawy przedsiębiorczości'),
('wiedza o społeczeństwie');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `RokSettings`
--

CREATE TABLE `RokSettings` (
  `rokSzk` int(11) NOT NULL,
  `semestr` int(11) NOT NULL,
  `ileTygodni` int(11) NOT NULL,
  `miesiacRozliczeniowy` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `RokSettings`
--

INSERT INTO `RokSettings` (`rokSzk`, `semestr`, `ileTygodni`, `miesiacRozliczeniowy`) VALUES
(2023, 1, 8, 'październik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczniowie`
--

CREATE TABLE `uczniowie` (
  `id` int(3) NOT NULL,
  `imie` varchar(11) DEFAULT NULL,
  `nazwisko` varchar(17) DEFAULT NULL,
  `klasa` varchar(3) NOT NULL,
  `rocznik` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `uczniowie`
--

INSERT INTO `uczniowie` (`id`, `imie`, `nazwisko`, `klasa`, `rocznik`) VALUES
(1, 'Anastazja', 'Alefierowicz', 'A', 2022),
(2, 'Dorota', 'Biłek', 'A', 2022),
(3, 'Wiktoria', 'Bogunia', 'A', 2022),
(4, 'Zofia', 'Byrtek', 'A', 2022),
(5, 'Oskar', 'Cembala', 'A', 2022),
(6, 'Martyna', 'Chrobak', 'A', 2022),
(7, 'Alicja', 'Dobrzyńska', 'A', 2022),
(8, 'Maja', 'Gajda', 'A', 2022),
(9, 'Hanna', 'Gawlik', 'A', 2022),
(10, 'Amelia', 'Gleindek', 'A', 2022),
(11, 'Maksymilian', 'Grzywacz', 'A', 2022),
(12, 'Zofia', 'Hańska', 'A', 2022),
(13, 'Julia', 'Hefner', 'A', 2022),
(14, 'Laura', 'Karwatowicz', 'A', 2022),
(15, 'Michał', 'Korczyk', 'A', 2022),
(16, 'Jakub', 'Kowalówka', 'A', 2022),
(17, 'Aleksandra', 'Kubik', 'A', 2022),
(18, 'Amelia', 'Kukla', 'A', 2022),
(19, 'Marta', 'Kurzeja', 'A', 2022),
(20, 'Ahmad Ilyas', 'Momand', 'A', 2022),
(21, 'Mirela', 'Niesytko', 'A', 2022),
(22, 'Adrian', 'Nowak', 'A', 2022),
(23, 'Jagoda', 'Ochal', 'A', 2022),
(24, 'Wiktoria', 'Pach', 'A', 2022),
(25, 'Maja', 'Romicka', 'A', 2022),
(26, 'Mateusz', 'Sikora', 'A', 2022),
(27, 'Adrianna', 'Sohlich', 'A', 2022),
(28, 'Amelia', 'Stec', 'A', 2022),
(29, 'Kamil', 'Talik', 'A', 2022),
(30, 'Amelia', 'Twardzik', 'A', 2022),
(31, 'Olga', 'Wróbel', 'A', 2022),
(32, 'Wiktoria', 'Zoń', 'A', 2022),
(33, 'Monika', 'Zwardoń', 'A', 2022),
(34, 'Roch', 'Dziembowski', 'A', 2022),
(35, 'Anita', 'Ciupak', 'B', 2022),
(36, 'Kinga', 'Drewniany', 'B', 2022),
(37, 'Piotr', 'Dymek', 'B', 2022),
(38, 'Amelia', 'Gibas', 'B', 2022),
(39, 'Kamil', 'Gołąb', 'B', 2022),
(40, 'Julia', 'Gwoździewicz', 'B', 2022),
(41, 'Michał', 'Herman', 'B', 2022),
(42, 'Bartosz', 'Izydorczyk', 'B', 2022),
(43, 'Maja', 'Jagiełło', 'B', 2022),
(44, 'Patryk', 'Kaizar', 'B', 2022),
(45, 'Oliwia', 'Kasperek', 'B', 2022),
(46, 'Marta', 'Kawa', 'B', 2022),
(47, 'Wojciech', 'Klajmon', 'B', 2022),
(48, 'Sara', 'Kociołek', 'B', 2022),
(49, 'Wiktoria', 'Kubiak', 'B', 2022),
(50, 'Magdalena', 'Kudla', 'B', 2022),
(51, 'Martyna', 'Lamczyk', 'B', 2022),
(52, 'Milena', 'Leszczyńska', 'B', 2022),
(53, 'Hanna', 'Loska', 'B', 2022),
(54, 'Barbara', 'Mikołajewska', 'B', 2022),
(55, 'Kamila', 'Nykiel', 'B', 2022),
(56, 'Weronika', 'Odoj', 'B', 2022),
(57, 'Tomasz', 'Osiński', 'B', 2022),
(58, 'Amelia', 'Pach', 'B', 2022),
(59, 'Julia', 'Pach', 'B', 2022),
(60, 'Aleksandra', 'Ponikiewska', 'B', 2022),
(61, 'Karol', 'Rączka', 'B', 2022),
(62, 'Kamil', 'Sablik', 'B', 2022),
(63, 'Vladyslava', 'Shatokhina', 'B', 2022),
(64, 'Jeremiasz', 'Słonka', 'B', 2022),
(65, 'Maria', 'Smoter', 'B', 2022),
(66, 'Dominika', 'Spek', 'B', 2022),
(67, 'Martyna', 'Wilk', 'B', 2022),
(68, 'Anastasiia', 'Yaremenko', 'B', 2022),
(69, 'Piotr', 'Babina', 'C', 2022),
(70, 'Bartosz', 'Bańka', 'C', 2022),
(71, 'Maciej', 'Barcik', 'C', 2022),
(72, 'Beata', 'Bąk', 'C', 2022),
(73, 'Filip', 'Bogusz', 'C', 2022),
(74, 'Aleksandra', 'Brzęk', 'C', 2022),
(75, 'Małgorzata', 'Buda', 'C', 2022),
(76, 'Tymon', 'Budziaszek', 'C', 2022),
(77, 'Emilia', 'Czernek', 'C', 2022),
(78, 'Olga ', 'Danek', 'C', 2022),
(79, 'Martyna', 'Gawlik', 'C', 2022),
(80, 'Zuzanna', 'Gazda', 'C', 2022),
(81, 'Barbara', 'Grabska', 'C', 2022),
(82, 'Oliwier', 'Guzdek', 'C', 2022),
(83, 'Kinga', 'Jabłonka', 'C', 2022),
(84, 'Mieszko', 'Janus', 'C', 2022),
(85, 'Martyna', 'Kamińska', 'C', 2022),
(86, 'Bruno', 'Keita', 'C', 2022),
(87, 'Anna', 'Kiełbas', 'C', 2022),
(88, 'Jagoda', 'Klaja', 'C', 2022),
(89, 'Zofia', 'Kramarczyk', 'C', 2022),
(90, 'Kamil', 'Leszczorz', 'C', 2022),
(91, 'Klaudia', 'Łukosz', 'C', 2022),
(92, 'Monika', 'Machowska', 'C', 2022),
(93, 'Mateusz', 'Marasek', 'C', 2022),
(94, 'Igor', 'Musiał', 'C', 2022),
(95, 'Julia', 'Nikiel', 'C', 2022),
(96, 'Michalina', 'Nycz', 'C', 2022),
(97, 'Szymon', 'Osika', 'C', 2022),
(98, 'Karolina', 'Stecyk', 'C', 2022),
(99, 'Wojciech', 'Tymich', 'C', 2022),
(100, 'Justyna', 'Wizner', 'C', 2022),
(101, 'Franciszek', 'Zadora', 'C', 2022),
(102, 'Natalia', 'Sojka', 'C', 2022),
(103, 'Dominik', 'Brunowski', 'D', 2022),
(104, 'Maciej', 'Capłap', 'D', 2022),
(105, 'Mateusz', 'Chrapek', 'D', 2022),
(106, 'Patryk', 'Czader', 'D', 2022),
(107, 'Mateusz', 'Gicala', 'D', 2022),
(108, 'Mateusz', 'Hulbój', 'D', 2022),
(109, 'Szymon', 'Jarosz', 'D', 2022),
(110, 'Iwo', 'Jeleśniański', 'D', 2022),
(111, 'Bartosz', 'Jurzak', 'D', 2022),
(112, 'Anna', 'Kaczmarek', 'D', 2022),
(113, 'Jakub', 'Kania', 'D', 2022),
(114, 'Tomasz', 'Kołodziejczyk', 'D', 2022),
(115, 'Emilia', 'Krzysztyniak', 'D', 2022),
(116, 'Emilia', 'Kwaśniewska', 'D', 2022),
(117, 'Stanisław', 'Lipiński', 'D', 2022),
(118, 'Szymon', 'Łaciak', 'D', 2022),
(119, 'Dawid', 'Maciaszek', 'D', 2022),
(120, 'Filip', 'Małysiak', 'D', 2022),
(121, 'Adam', 'Przybyła', 'D', 2022),
(122, 'Jan', 'Pyclik', 'D', 2022),
(123, 'Maciej ', 'Robakiewicz', 'D', 2022),
(124, 'Mateusz', 'Siwik', 'D', 2022),
(125, 'Sara', 'Słońska', 'D', 2022),
(126, 'Wiktoria', 'Strzop', 'D', 2022),
(127, 'Rafał', 'Syta', 'D', 2022),
(128, 'Nikodem', 'Wala', 'D', 2022),
(129, 'Mateusz', 'Wójcik', 'D', 2022),
(130, 'Mateusz', 'Jawura', 'D', 2022),
(131, 'Bruno', 'Kubalańca', 'D', 2022),
(132, 'Julia', 'Bogisz', 'E', 2022),
(133, 'Marek', 'Brach', 'E', 2022),
(134, 'Klaudia', 'Buława', 'E', 2022),
(135, 'Kinga', 'Chanek', 'E', 2022),
(136, 'Karol', 'Czajkowski', 'E', 2022),
(137, 'Karolina', 'Czajowska', 'E', 2022),
(138, 'Julita', 'Darmofał', 'E', 2022),
(139, 'Julia', 'Dwornik', 'E', 2022),
(140, 'Marta', 'Dyczek', 'E', 2022),
(141, 'Pola', 'Dziubek', 'E', 2022),
(142, 'Natalia', 'Foltyn', 'E', 2022),
(143, 'Antonina', 'Janusz', 'E', 2022),
(144, 'Maja', 'Kądzioła', 'E', 2022),
(145, 'Zuzanna', 'Kmiecik', 'E', 2022),
(146, 'Zuzanna', 'Kokot', 'E', 2022),
(147, 'Dominika', 'Kolonko', 'E', 2022),
(148, 'Zuzanna', 'Kudrys', 'E', 2022),
(149, 'Szymon', 'Lickiewicz', 'E', 2022),
(150, 'Oliver', 'Mazur', 'E', 2022),
(151, 'Zofia', 'Mikłusiak', 'E', 2022),
(152, 'Amelia', 'Mikołajczyk', 'E', 2022),
(153, 'Bartosz', 'Olejnik', 'E', 2022),
(154, 'Robert', 'Płoskonka', 'E', 2022),
(155, 'Julia', 'Popławska', 'E', 2022),
(156, 'Maja', 'Raciak', 'E', 2022),
(157, 'Natan', 'Szczepara', 'E', 2022),
(158, 'Karina', 'Tora', 'E', 2022),
(159, 'Marta', 'Wątroba', 'E', 2022),
(160, 'Weronika', 'Żmuda', 'E', 2022),
(161, 'Oliwia', 'Pastuszczak', 'E', 2022),
(162, 'Michalina', 'Płonka', 'E', 2022),
(163, 'Wojciech', 'Zaniewski', 'E', 2022),
(164, 'Wojciech', 'Kosarski', 'E', 2022),
(165, 'Alan', 'Adamski', 'F', 2022),
(166, 'Oleksandra', 'Belitska', 'F', 2022),
(167, 'Agata', 'Błotko', 'F', 2022),
(168, 'Wiktoria', 'Chrobak', 'F', 2022),
(169, 'Olena', 'Chykalenko', 'F', 2022),
(170, 'Julia', 'Ćwikła', 'F', 2022),
(171, 'Ignacy', 'Dembiński', 'F', 2022),
(172, 'Mateusz', 'Domagała', 'F', 2022),
(173, 'Filip', 'Fiałek', 'F', 2022),
(174, 'Wiktoria', 'Jopek', 'F', 2022),
(175, 'Szymon', 'Kamiński', 'F', 2022),
(176, 'Hanna', 'Kucharska', 'F', 2022),
(177, 'Artur', 'Mazur', 'F', 2022),
(178, 'Maja', 'Mazurek', 'F', 2022),
(179, 'Nikola', 'Mirka', 'F', 2022),
(180, 'Maja', 'Padula', 'F', 2022),
(181, 'Marta', 'Pietras ', 'F', 2022),
(182, 'Filip', 'Płachta', 'F', 2022),
(183, 'Amelia', 'Przybyła', 'F', 2022),
(184, 'Marcin', 'Pyka', 'F', 2022),
(185, 'Helena', 'Sieczkowska', 'F', 2022),
(186, 'Róża', 'Stasica', 'F', 2022),
(187, 'Michał', 'Stefan', 'F', 2022),
(188, 'Julia', 'Szczypkowska', 'F', 2022),
(189, 'Justyna', 'Szuler', 'F', 2022),
(190, 'Barbara', 'Szwarc', 'F', 2022),
(191, 'Jakub', 'Szymkowski', 'F', 2022),
(192, 'Seweryn', 'Węglarz', 'F', 2022),
(193, 'Kamil', 'Więzik', 'F', 2022),
(194, 'Elżbieta', 'Woźniak', 'F', 2022),
(195, 'Magdalena', 'Wrzoł', 'F', 2022),
(196, 'Iga', 'Staszkiewicz', 'F', 2022),
(197, 'Aleksander', 'Bylica', 'G', 2022),
(198, 'Bruno', 'Byra', 'G', 2022),
(199, 'Karol', 'Chodorowski', 'G', 2022),
(200, 'Paweł', 'Gańczarczyk', 'G', 2022),
(201, 'Konrad', 'Guszpil', 'G', 2022),
(202, 'Nicolas', 'Jop', 'G', 2022),
(203, 'Olaf', 'Kędelski', 'G', 2022),
(204, 'Bartosz', 'Kołton', 'G', 2022),
(205, 'Wojciech', 'Kopacz', 'G', 2022),
(206, 'Przemysław', 'Lubos', 'G', 2022),
(207, 'Amelia', 'Marcisz', 'G', 2022),
(208, 'Jakub', 'Matkowski', 'G', 2022),
(209, 'Radosław ', 'Piegza', 'G', 2022),
(210, 'Adrian', 'Rogol', 'G', 2022),
(211, 'Milena', 'Sebestiańska', 'G', 2022),
(212, 'Oleksandr', 'Shevchenko', 'G', 2022),
(213, 'Denys', 'Shun', 'G', 2022),
(214, 'Maria', 'Słodownik', 'G', 2022),
(215, 'Bohdan', 'Solodun', 'G', 2022),
(216, 'Antoni', 'Szmajduch', 'G', 2022),
(217, 'Wiktor', 'Szwajca', 'G', 2022),
(218, 'Igor', 'Śliwa', 'G', 2022),
(219, 'Konrad', 'Trębla', 'G', 2022),
(220, 'Liliia', 'Tsyhanii', 'G', 2022),
(221, 'Przemysław', 'Utrata', 'G', 2022),
(222, 'Mateusz', 'Włoch', 'G', 2022),
(223, 'Emilia', 'Wolny', 'G', 2022),
(224, 'Iliia', 'Yefimov', 'G', 2022),
(225, 'Ivan', 'Zelmanchuk', 'G', 2022),
(226, 'Jan', 'Bukowski', 'G', 2022),
(227, 'Weronika', 'Andruszkiewicz', 'A', 2021),
(228, 'Paulina', 'Bałucka', 'A', 2021),
(229, 'Emilia', 'Domaradzka', 'A', 2021),
(230, 'Dominika', 'Dziergas', 'A', 2021),
(231, 'Gabriela', 'Gacek', 'A', 2021),
(232, 'Weronika', 'Gańczarczyk', 'A', 2021),
(233, 'Aleksandra', 'Górniak', 'A', 2021),
(234, 'Anna', 'Hałat', 'A', 2021),
(235, 'Maja', 'Jakubiec', 'A', 2021),
(236, 'Nadia', 'Kliś', 'A', 2021),
(237, 'Irys', 'Kornasiewicz', 'A', 2021),
(238, 'Aleksandra', 'Kulawiak', 'A', 2021),
(239, 'Anna', 'Laskoś', 'A', 2021),
(240, 'Joanna', 'Lorek', 'A', 2021),
(241, 'Maria', 'Madejska', 'A', 2021),
(242, 'Anna', 'Mucha', 'A', 2021),
(243, 'Katarzyna', 'Noga', 'A', 2021),
(244, 'Magdalena', 'Owczarz', 'A', 2021),
(245, 'Zuzanna', 'Pastor', 'A', 2021),
(246, 'Marta', 'Piecha', 'A', 2021),
(247, 'Wiktoria', 'Przybycień', 'A', 2021),
(248, 'Alicja', 'Rdest', 'A', 2021),
(249, 'Julita', 'Rozner', 'A', 2021),
(250, 'Maja', 'Rusin', 'A', 2021),
(251, 'Maja', 'Sikora', 'A', 2021),
(252, 'Artur', 'Sitek', 'A', 2021),
(253, 'Kamil', 'Stasiewicz', 'A', 2021),
(254, 'Maja', 'Straszyńska', 'A', 2021),
(255, 'Weronika ', 'Waloszek', 'A', 2021),
(256, 'Maja', 'Wojtyła', 'A', 2021),
(257, 'Kamil', 'Zubek', 'A', 2021),
(258, 'Anna', 'Waląg', 'A', 2021),
(259, 'Magdalena', 'Antosik', 'B', 2021),
(260, 'Emilia', 'Baranowska', 'B', 2021),
(261, 'Natalia', 'Bąk', 'B', 2021),
(262, 'Julia', 'Bobkiewicz', 'B', 2021),
(263, 'Tymoteusz', 'Chrapek', 'B', 2021),
(264, 'Szymon', 'Czernek', 'B', 2021),
(265, ' Eduard', 'Fedchenko', 'B', 2021),
(266, 'Joanna', 'Godziek', 'B', 2021),
(267, 'Iga', 'Gołek', 'B', 2021),
(268, 'Wiktoria', 'Górska', 'B', 2021),
(269, 'Michał', 'Grzesica', 'B', 2021),
(270, 'Marcin', 'Jasiński', 'B', 2021),
(271, 'Maria', 'Kalabińska', 'B', 2021),
(272, 'Sofiia', 'Klimenko', 'B', 2021),
(273, 'Joanna', 'Krzempek', 'B', 2021),
(274, 'Oskar', 'Kusiński', 'B', 2021),
(275, 'Karolina', 'Lucka', 'B', 2021),
(276, 'Amelia', 'Łozdowska', 'B', 2021),
(277, 'Matylda', 'Mrowicka', 'B', 2021),
(278, 'Julita', 'Naumowicz', 'B', 2021),
(279, 'Milena', 'Oborzyńska', 'B', 2021),
(280, 'Bohdan', 'Oliinyk', 'B', 2021),
(281, 'Marcela', 'Polewska', 'B', 2021),
(282, 'Nadia', 'Purzycka', 'B', 2021),
(283, 'Natalia', 'Pytlarz', 'B', 2021),
(284, 'Julia', 'Sachmerda', 'B', 2021),
(285, 'Natalia', 'Sobkowicz', 'B', 2021),
(286, 'Jakub', 'Stwora', 'B', 2021),
(287, 'Filip', 'Szymański', 'B', 2021),
(288, 'Wiktoria', 'Tobor', 'B', 2021),
(289, 'Jan', 'Tyc', 'B', 2021),
(290, 'Beata', 'Włodek', 'B', 2021),
(291, 'Zuzanna', 'Wojtuś', 'B', 2021),
(292, 'Roksana', 'Wołyniec', 'B', 2021),
(293, 'Marek', 'Wrzoł', 'B', 2021),
(294, 'Emil', 'Biernat', 'C', 2021),
(295, 'Nikola', 'Bożek', 'C', 2021),
(296, 'Dawid', 'Brzęk', 'C', 2021),
(297, 'Paweł', 'Brzóska', 'C', 2021),
(298, 'Kacper', 'Capek', 'C', 2021),
(299, 'Adam', 'Derbin', 'C', 2021),
(300, 'Agata', 'Dziewulska', 'C', 2021),
(301, 'Małgorzata', 'Gawron', 'C', 2021),
(302, 'Kornelia', 'Gołyszny', 'C', 2021),
(303, 'Jakub', 'Gruszeczka', 'C', 2021),
(304, 'Agnieszka', 'Jabłonka', 'C', 2021),
(305, 'Julia', 'Jurasz', 'C', 2021),
(306, 'Zuzanna', 'Kajstura', 'C', 2021),
(307, 'Katarzyna', 'Kania', 'C', 2021),
(308, 'Elżbieta', 'Knapek', 'C', 2021),
(309, 'Kamil', 'Kolasa', 'C', 2021),
(310, 'Szymon', 'Konior', 'C', 2021),
(311, 'Milena', 'Kuś', 'C', 2021),
(312, 'Daria', 'Kwaśna', 'C', 2021),
(313, 'Oliwia', 'Lach', 'C', 2021),
(314, 'Wojciech', 'Lach', 'C', 2021),
(315, 'Anna', 'Łyczko', 'C', 2021),
(316, 'Klaudia', 'Matlak', 'C', 2021),
(317, 'Mikołaj', 'Michalik', 'C', 2021),
(318, 'Alicja', 'Olęcka', 'C', 2021),
(319, 'Bartłomiej', 'Pilich', 'C', 2021),
(320, 'Maja', 'Prochowska', 'C', 2021),
(321, 'Milena', 'Sablik', 'C', 2021),
(322, 'Justyna', 'Stekla', 'C', 2021),
(323, 'Natalia', 'Suska', 'C', 2021),
(324, 'Patryk', 'Szczotka', 'C', 2021),
(325, 'Jakub', 'Świstak', 'C', 2021),
(326, 'Tytus', 'Trembla', 'C', 2021),
(327, 'Klaudia', 'Zacny', 'C', 2021),
(328, 'Sandra', 'Skurzok', 'C', 2021),
(329, 'Krystian', 'Banet', 'D', 2021),
(330, 'Kamil', 'Bestwina', 'D', 2021),
(331, 'Michał', 'Bidas', 'D', 2021),
(332, 'Zuzanna', 'Bojdys', 'D', 2021),
(333, 'Mateusz', 'Dudek', 'D', 2021),
(334, 'Szymon', 'Dwornik', 'D', 2021),
(335, 'Maksymilian', 'Dziedzic', 'D', 2021),
(336, 'Oliwia', 'Faruga', 'D', 2021),
(337, 'Wojciech', 'Frączek', 'D', 2021),
(338, 'Michał', 'Fuchs', 'D', 2021),
(339, 'Tymoteusz', 'Giza', 'D', 2021),
(340, 'Łukasz', 'Gnela', 'D', 2021),
(341, 'Bartosz', 'Grzanka', 'D', 2021),
(342, 'Krystian', 'Hankus', 'D', 2021),
(343, 'Zuzanna', 'Iskierka', 'D', 2021),
(344, 'Szymon', 'Jarosz', 'D', 2021),
(345, 'Aleks', 'Jastrzębski', 'D', 2021),
(346, 'Filip', 'Juraszek', 'D', 2021),
(347, 'Igor', 'Kasiuba', 'D', 2021),
(348, 'Szymon', 'Kasperek', 'D', 2021),
(349, 'Kacper', 'Koczurek', 'D', 2021),
(350, 'Jakub', 'Kucharski', 'D', 2021),
(351, 'Jakub', 'Mańdok', 'D', 2021),
(352, 'Paweł', 'Moczek', 'D', 2021),
(353, 'Konrad', 'Musur', 'D', 2021),
(354, 'Maciej', 'Papierniak', 'D', 2021),
(355, 'Nikola', 'Rak', 'D', 2021),
(356, 'Jakub', 'Rosiński', 'D', 2021),
(357, 'Kacper', 'Stec ', 'D', 2021),
(358, 'Zuzanna', 'Szklarska', 'D', 2021),
(359, 'Julia', 'Ślusarczyk', 'D', 2021),
(360, 'Dawid', 'Świstun', 'D', 2021),
(361, 'Wiktoria', 'Wieczorek', 'D', 2021),
(362, 'Miłosz', 'Wołoch', 'D', 2021),
(363, 'Karol', 'Wrzosok', 'D', 2021),
(364, 'Larysa', 'Biegun', 'E', 2021),
(365, 'Julia', 'Bukowska', 'E', 2021),
(366, 'Julia', 'Ciućka', 'E', 2021),
(367, 'Tadeusz', 'Dziubek', 'E', 2021),
(368, 'Maria', 'Filipek', 'E', 2021),
(369, 'Jakub', 'Herok', 'E', 2021),
(370, 'Oliwia', 'Idzik', 'E', 2021),
(371, 'Hanna', 'Jafernik', 'E', 2021),
(372, 'Zofia', 'Janus', 'E', 2021),
(373, 'Monika', 'Kanik', 'E', 2021),
(374, 'Emilia', 'Kasprzak', 'E', 2021),
(375, 'Maria', 'Kopeć', 'E', 2021),
(376, 'Julia', 'Kowalska', 'E', 2021),
(377, 'Anna', 'Król', 'E', 2021),
(378, 'Zofia', 'Kuczera', 'E', 2021),
(379, 'Jagoda', 'Kućmierz', 'E', 2021),
(380, 'Laura', 'Machalica', 'E', 2021),
(381, 'Mikołaj', 'Merta', 'E', 2021),
(382, 'Marta', 'Mglej', 'E', 2021),
(383, 'Julia', 'Piekarczyk', 'E', 2021),
(384, 'Stanisław', 'Potoczny', 'E', 2021),
(385, 'Michał', 'Pszon', 'E', 2021),
(386, 'Laura', 'Romek', 'E', 2021),
(387, 'Nikola', 'Sachmerda', 'E', 2021),
(388, 'Zuzanna', 'Suchy', 'E', 2021),
(389, 'Nikola', 'Szczecińska', 'E', 2021),
(390, 'Lena', 'Trojak', 'E', 2021),
(391, 'Karol', 'Trzopek', 'E', 2021),
(392, 'Jakub', 'Wiewióra', 'E', 2021),
(393, 'Marta', 'Wiewióra', 'E', 2021),
(394, 'Emilia', 'Włosek', 'E', 2021),
(395, 'Weronika', 'Wolska', 'E', 2021),
(396, 'Aleksandra', 'Wrzosek', 'E', 2021),
(397, 'Maria', 'Zagórska', 'E', 2021),
(398, 'Wiktoria', 'Ziaja', 'E', 2021),
(399, 'Maya', 'Żurek', 'E', 2021),
(400, 'Dominika', 'Adamek', 'A', 2020),
(401, 'Veronika', 'Antonenko', 'A', 2020),
(402, 'Paulina', 'Banaszewska', 'A', 2020),
(403, 'Lena', 'Boduch', 'A', 2020),
(404, 'Emilia', 'Borowska', 'A', 2020),
(405, 'Melania', 'Ciurla', 'A', 2020),
(406, 'Maja', 'Dwornicka', 'A', 2020),
(407, 'Grzegorz', 'Dyczkowski', 'A', 2020),
(408, 'Anna', 'Fajkis', 'A', 2020),
(409, 'Tomasz', 'Frąc', 'A', 2020),
(410, 'Paulina', 'Gacek', 'A', 2020),
(411, 'Maja', 'Genc', 'A', 2020),
(412, 'Tatiana', 'Gromada', 'A', 2020),
(413, 'Martyna', 'Hula', 'A', 2020),
(414, 'Patrycja', 'Józefowska', 'A', 2020),
(415, 'Agata', 'Jurzak', 'A', 2020),
(416, 'Emilia', 'Klejnocka', 'A', 2020),
(417, 'Jagoda', 'Koniuszy', 'A', 2020),
(418, 'Szymon', 'Kowalcze', 'A', 2020),
(419, 'Paulina', 'Ochwat', 'A', 2020),
(420, 'Julia', 'Olejnik', 'A', 2020),
(421, 'Filip', 'Olszowy', 'A', 2020),
(422, 'Filip', 'Przepiórka', 'A', 2020),
(423, 'Martyna', 'Rajda', 'A', 2020),
(424, 'Wiktoria', 'Saternus', 'A', 2020),
(425, 'Zofia', 'Skrudlik', 'A', 2020),
(426, 'Magdalena', 'Stachak', 'A', 2020),
(427, 'Emilia', 'Surdy', 'A', 2020),
(428, 'Paulina', 'Szumlas', 'A', 2020),
(429, 'Aleksandra', 'Wiewióra', 'A', 2020),
(430, 'Julia', 'Zięba', 'A', 2020),
(431, 'Sara', 'Banach', 'B', 2020),
(432, 'Paulina', 'Białoń', 'B', 2020),
(433, 'Emilia', 'Biernatek', 'B', 2020),
(434, 'Franek', 'Brawański', 'B', 2020),
(435, 'Oliwia', 'Bułka', 'B', 2020),
(436, 'Maciej', 'Bylinko', 'B', 2020),
(437, 'Julia', 'Czyżowska', 'B', 2020),
(438, 'Amelia', 'Faruga', 'B', 2020),
(439, 'Justyna', 'Honkisz', 'B', 2020),
(440, 'Franciszek', 'Janik', 'B', 2020),
(441, 'Kinga', 'Jasiewicz', 'B', 2020),
(442, 'Zuzanna', 'Kania', 'B', 2020),
(443, 'Marta', 'Kępińska', 'B', 2020),
(444, 'Julia', 'Kieczka', 'B', 2020),
(445, 'Julia', 'Kiełbowicz', 'B', 2020),
(446, 'Maciej', 'Komędera', 'B', 2020),
(447, 'Aleksandra', 'Kostka', 'B', 2020),
(448, 'Julia', 'Krysta', 'B', 2020),
(449, 'Igor', 'Kudyba', 'B', 2020),
(450, 'Dominik', 'Leśniak', 'B', 2020),
(451, 'Emilia', 'Muzyka', 'B', 2020),
(452, 'Paulina', 'Mynarska', 'B', 2020),
(453, 'Monika', 'Nowak', 'B', 2020),
(454, 'Kamil', 'Pakosz', 'B', 2020),
(455, 'Adam', 'Piekuś', 'B', 2020),
(456, 'Paulina', 'Płonka', 'B', 2020),
(457, 'Kinga', 'Polak', 'B', 2020),
(458, 'Karolina', 'Pop', 'B', 2020),
(459, 'Monika', 'Sala', 'B', 2020),
(460, 'Mateusz', 'Sierek', 'B', 2020),
(461, 'Rozalia', 'Sporek', 'B', 2020),
(462, 'Magdalena', 'Spyra', 'B', 2020),
(463, 'Anna', 'Sznyr', 'B', 2020),
(464, 'Natalia', 'Świątkiewicz', 'B', 2020),
(465, 'Igor', 'Borkowski', 'C', 2020),
(466, 'Wiktoria', 'Bujak', 'C', 2020),
(467, 'Nicole', 'Ceklarz', 'C', 2020),
(468, 'Wiktoria', 'Domagała', 'C', 2020),
(469, 'Olgierd', 'Furtak', 'C', 2020),
(470, 'Igor', 'Giertler', 'C', 2020),
(471, 'Wiktoria', 'Kilarska', 'C', 2020),
(472, 'Kajetan', 'Kolek', 'C', 2020),
(473, 'Kinga', 'Kołek', 'C', 2020),
(474, 'Oliwia', 'Krajewska', 'C', 2020),
(475, 'Kacper', 'Kruczek', 'C', 2020),
(476, 'Jakub', 'Krzykowski', 'C', 2020),
(477, 'Igor', 'Kubicki', 'C', 2020),
(478, 'Julia', 'Kuczmierczyk', 'C', 2020),
(479, 'Nicola', 'Łasak', 'C', 2020),
(480, 'Marcel', 'Nevedel', 'C', 2020),
(481, 'Daniel', 'Nikiel', 'C', 2020),
(482, 'Marta', 'Nowakowska', 'C', 2020),
(483, 'Katarzyna', 'Ochman', 'C', 2020),
(484, 'Jakub', 'Rzepus', 'C', 2020),
(485, 'Magdalena', 'Sanetra', 'C', 2020),
(486, 'Maja', 'Semeniuk', 'C', 2020),
(487, 'Aleksandra', 'Sitarz', 'C', 2020),
(488, 'Natalia', 'Szpila', 'C', 2020),
(489, 'Sebastian', 'Świerczek', 'C', 2020),
(490, 'Katarzyna', 'Trojanowska', 'C', 2020),
(491, 'Nadia', 'Tront', 'C', 2020),
(492, 'Natalia', 'Wawak', 'C', 2020),
(493, 'Ewelina', 'Więzik', 'C', 2020),
(494, 'Magdalena', 'Ziarko', 'C', 2020),
(495, 'Julia', 'Banach', 'D', 2020),
(496, 'Kinga', 'Bączek', 'D', 2020),
(497, 'Zuzanna ', 'Bąk', 'D', 2020),
(498, 'Szczepan', 'Będziński', 'D', 2020),
(499, 'Maksymilian', 'Boczar', 'D', 2020),
(500, 'Oskar', 'Damasiewicz', 'D', 2020),
(501, 'Kacper', 'Fijak', 'D', 2020),
(502, 'Vlas', 'Golubev', 'D', 2020),
(503, 'Gajane', 'Grigorjan', 'D', 2020),
(504, 'Stanisław', 'Heczko', 'D', 2020),
(505, 'Sawielij', 'Iwanow', 'D', 2020),
(506, 'Filip', 'Jagła', 'D', 2020),
(507, 'Adrian', 'Kamiński', 'D', 2020),
(508, 'Jakub', 'Klimunt', 'D', 2020),
(509, 'Radosław', 'Kołton', 'D', 2020),
(510, 'Antoni', 'Kominiak', 'D', 2020),
(511, 'Wiktoria', 'Kubisiak', 'D', 2020),
(512, 'Krystian', 'Loranc', 'D', 2020),
(513, 'Dawid', 'Lukowiec', 'D', 2020),
(514, 'Ahmad Wais', 'Momand', 'D', 2020),
(515, 'Ahmad Qais', 'Momand', 'D', 2020),
(516, 'Maja', 'Mościcka', 'D', 2020),
(517, 'Mateusz', 'Nowak', 'D', 2020),
(518, 'Kamil', 'Papatanasiu', 'D', 2020),
(519, 'Joanna', 'Pawlus', 'D', 2020),
(520, 'Oskar', 'Przybył', 'D', 2020),
(521, 'Ewelina', 'Rybica', 'D', 2020),
(522, 'Dominika', 'Salachna', 'D', 2020),
(523, 'Martyna', 'Sekuła', 'D', 2020),
(524, 'Grażyna', 'Spila', 'D', 2020),
(525, 'Mateusz', 'Szabat', 'D', 2020),
(526, 'Olaf', 'Szlęk', 'D', 2020),
(527, 'Mateusz', 'Widuch', 'D', 2020),
(528, 'Michał', 'Wydrzyński', 'D', 2020),
(529, 'Paweł', 'Zmełty', 'D', 2020),
(530, 'Dawid', 'Adamaszek', 'E', 2020),
(531, 'Oliwia', 'Bernat', 'E', 2020),
(532, 'Robert', 'Budnik', 'E', 2020),
(533, 'Mateusz', 'Chrapek', 'E', 2020),
(534, 'Sebastian', 'Cieślak', 'E', 2020),
(535, 'Dawid', 'Dybał', 'E', 2020),
(536, 'Emilia', 'Furczyk', 'E', 2020),
(537, 'Karolina', 'Gajda', 'E', 2020),
(538, 'Martyna', 'Gasidło', 'E', 2020),
(539, 'Iga', 'Goliasz', 'E', 2020),
(540, 'Maja', 'Górska', 'E', 2020),
(541, 'Aleksandra', 'Grabowska', 'E', 2020),
(542, 'Julia', 'Hajost', 'E', 2020),
(543, 'Mateusz', 'Hawliczek', 'E', 2020),
(544, 'Bartosz', 'Jedynak', 'E', 2020),
(545, 'Natalia', 'Jurak', 'E', 2020),
(546, 'Natalia', 'Kierpiec', 'E', 2020),
(547, 'Karolina', 'Kobielska', 'E', 2020),
(548, 'Teresa', 'Kosyk', 'E', 2020),
(549, 'Karolina', 'Koziołek', 'E', 2020),
(550, 'Kinga', 'Kwaśny', 'E', 2020),
(551, 'Natalia', 'Kwiecińska', 'E', 2020),
(552, 'Oliwia', 'Loranc', 'E', 2020),
(553, 'Karolina', 'Nowak', 'E', 2020),
(554, 'Anna', 'Piechówka', 'E', 2020),
(555, 'Martyna', 'Przybyła', 'E', 2020),
(556, 'Julia', 'Raczkiewicz', 'E', 2020),
(557, 'Zofia', 'Rozbicka', 'E', 2020),
(558, 'Nela', 'Sikora', 'E', 2020),
(559, 'Maja', 'Siwek', 'E', 2020),
(560, 'Christian', 'Soroczyński-Gajer', 'E', 2020),
(561, 'Justyna', 'Stanclik', 'E', 2020),
(562, 'Oliwier', 'Śliwiany', 'E', 2020),
(563, 'Kacper', 'Śmigiel', 'E', 2020),
(564, 'Kamila', 'Tomaszczyk', 'E', 2020),
(565, 'Jakub', 'Wikło', 'E', 2020),
(566, 'Emilia', 'Bauza', 'A', 2019),
(567, 'Kacper', 'Bemben', 'A', 2019),
(568, 'Julia', 'Biegun', 'A', 2019),
(569, 'Wiktoria', 'Chachlowska', 'A', 2019),
(570, 'Paula', 'Górak', 'A', 2019),
(571, 'Maja', 'Jano', 'A', 2019),
(572, 'Julia', 'Kalicińska', 'A', 2019),
(573, 'Magdalena', 'Kłak', 'A', 2019),
(574, 'Julia', 'Knips', 'A', 2019),
(575, 'Tomasz', 'Kręcichwost', 'A', 2019),
(576, 'Magdalena', 'Kuchejda', 'A', 2019),
(577, 'Anna', 'Kurowska', 'A', 2019),
(578, 'Emilia', 'Laszczak', 'A', 2019),
(579, 'Hanna', 'Mazurek', 'A', 2019),
(580, 'Weronika', 'Mięksiak', 'A', 2019),
(581, 'Kordian', 'Nowak', 'A', 2019),
(582, 'Matylda', 'Paszek', 'A', 2019),
(583, 'Wiktoria', 'Puzoń', 'A', 2019),
(584, 'Mikołaj', 'Skaziak', 'A', 2019),
(585, 'Joanna', 'Słodczyk', 'A', 2019),
(586, 'Filip', 'Stankiewicz', 'A', 2019),
(587, 'Irma', 'Trybura', 'A', 2019),
(588, 'Bartłomiej', 'Wala', 'A', 2019),
(589, 'Barbara', 'Waliczek', 'A', 2019),
(590, 'Katarzyna', 'Weigel', 'A', 2019),
(591, 'Zofia', 'Wieczorek', 'A', 2019),
(592, 'Piotr', 'Wójcik', 'A', 2019),
(593, 'Adrianna', 'Żurowska', 'A', 2019),
(594, 'Natalia', 'Rusin', 'A', 2019),
(595, 'Julia', 'Cholewa', 'B', 2019),
(596, 'Monika', 'Domiter', 'B', 2019),
(597, 'Mikołaj', 'Fabirkiewicz', 'B', 2019),
(598, 'Martyna', 'Gębala', 'B', 2019),
(599, 'Oliwia', 'Gołąb', 'B', 2019),
(600, 'Andrzej', 'Gomółka', 'B', 2019),
(601, 'Konrad', 'Handzlik', 'B', 2019),
(602, 'Mateusz', 'Krywult', 'B', 2019),
(603, 'Agnieszka', 'Kućka', 'B', 2019),
(604, 'Martyna', 'Kumorek', 'B', 2019),
(605, 'Hanna', 'Kuszmider', 'B', 2019),
(606, 'Julia', 'Kut', 'B', 2019),
(607, 'Zuzanna', 'Matlak', 'B', 2019),
(608, 'Tacjana', 'Matuszek', 'B', 2019),
(609, 'Emilia', 'Mieszczak', 'B', 2019),
(610, 'Natalia', 'Morawska', 'B', 2019),
(611, 'Natalia', 'Nowak', 'B', 2019),
(612, 'Nicola', 'Osowiec', 'B', 2019),
(613, 'Sara', 'Pałamarz', 'B', 2019),
(614, 'Dariusz', 'Siek', 'B', 2019),
(615, 'Amelia', 'Sławińska', 'B', 2019),
(616, 'Oliwia', 'Sroka', 'B', 2019),
(617, 'Agnieszka', 'Stusek', 'B', 2019),
(618, 'Maciej', 'Szczerba', 'B', 2019),
(619, 'Anna', 'Szczerbik', 'B', 2019),
(620, 'Marta', 'Śmiechura', 'B', 2019),
(621, 'Róża', 'Urbaniec', 'B', 2019),
(622, 'Izabela', 'Węgrzyn', 'B', 2019),
(623, 'Mateusz', 'Zyzak', 'B', 2019),
(624, 'Adrian', 'Andreczko', 'C', 2019),
(625, 'Maksymilian', 'Biegun', 'C', 2019),
(626, 'Dawid', 'Bohaczyk', 'C', 2019),
(627, 'Emilia', 'Chrobok', 'C', 2019),
(628, 'Bartosz', 'Cierlicki', 'C', 2019),
(629, 'Maciej', 'Dębski', 'C', 2019),
(630, 'Kamil', 'Domowicz', 'C', 2019),
(631, 'Kalina', 'Dziubek', 'C', 2019),
(632, 'Adrien', 'Grzywna', 'C', 2019),
(633, 'Oliwia', 'Gurzawska', 'C', 2019),
(634, 'Maria', 'Kamińska', 'C', 2019),
(635, 'Michał', 'Karelus', 'C', 2019),
(636, 'Zofia', 'Kasztura', 'C', 2019),
(637, 'Wojciech', 'Kisiel', 'C', 2019),
(638, 'Anna', 'Komędera', 'C', 2019),
(639, 'Nikola', 'Kost', 'C', 2019),
(640, 'Inga', 'Kowalska', 'C', 2019),
(641, 'Julia', 'Lahutta', 'C', 2019),
(642, 'Dawid', 'Linnert', 'C', 2019),
(643, 'Mikołaj', 'Łaciak', 'C', 2019),
(644, 'Iga', 'Machalica', 'C', 2019),
(645, 'Aleksandra', 'Mędrala', 'C', 2019),
(646, 'Kamil', 'Miłek', 'C', 2019),
(647, 'Wojciech', 'Palarz', 'C', 2019),
(648, 'Oliwia', 'Rokosz', 'C', 2019),
(649, 'Konrad', 'Sekunda', 'C', 2019),
(650, 'Kacper', 'Sikora', 'C', 2019),
(651, 'Mateusz', 'Skiba', 'C', 2019),
(652, 'Igor', 'Sotirov', 'C', 2019),
(653, 'Martin', 'Stanclik', 'C', 2019),
(654, 'Kamil', 'Śleziński', 'C', 2019),
(655, 'Dawid', 'Tarnawa', 'C', 2019),
(656, 'Karolina', 'Tarnawa', 'C', 2019),
(657, 'Jakub', 'Wandzel', 'C', 2019),
(658, 'Paweł', 'Wiktorko', 'C', 2019),
(659, 'Karolina', 'Żmij', 'C', 2019),
(660, 'Marek', 'Bachowski', 'D', 2019),
(661, 'Kacper', 'Baum-Azbum', 'D', 2019),
(662, 'Szymon', 'Cichowski', 'D', 2019),
(663, 'Aleksandra', 'Czarnota', 'D', 2019),
(664, 'Patryk', 'Gabryś', 'D', 2019),
(665, 'Amelia', 'Janek', 'D', 2019),
(666, 'Dominik', 'Jero', 'D', 2019),
(667, 'Patrycja', 'Kanik', 'D', 2019),
(668, 'Hanna', 'Kapska', 'D', 2019),
(669, 'Zofia', 'Komendera', 'D', 2019),
(670, 'Tymon', 'Kosicki', 'D', 2019),
(671, 'Aleksandra', 'Kuś', 'D', 2019),
(672, 'Eliza', 'Marcinkiewicz', 'D', 2019),
(673, 'Michał', 'Marcjanik', 'D', 2019),
(674, 'Sara', 'Martyniak', 'D', 2019),
(675, 'Michał', 'Michałowski', 'D', 2019),
(676, 'Maksymilian', 'Miech', 'D', 2019),
(677, 'Artur', 'Niemiec', 'D', 2019),
(678, 'Stanisław', 'Nosalik', 'D', 2019),
(679, 'Igor', 'Nowak', 'D', 2019),
(680, 'Mikołaj', 'Romański', 'D', 2019),
(681, 'Weronika', 'Seremet', 'D', 2019),
(682, 'Dominik', 'Skudlarski', 'D', 2019),
(683, 'Adrian', 'Sładczyk', 'D', 2019),
(684, 'Jakub', 'Słapa', 'D', 2019),
(685, 'Dominika', 'Sojka', 'D', 2019),
(686, 'Dominik', 'Stanclik', 'D', 2019),
(687, 'Karol', 'Widera', 'D', 2019),
(688, 'Michał', 'Włodek', 'D', 2019),
(689, 'Jakub', 'Wojcieszyk', 'D', 2019),
(690, 'Kamil', 'Jach', 'D', 2019),
(691, 'Wojciech', 'Lewanda', 'D', 2019),
(692, 'Marcin', 'Bizoń', 'E', 2019),
(693, 'Julia', 'Cecotka', 'E', 2019),
(694, 'Sonia', 'Chwałka', 'E', 2019),
(695, 'Aneta', 'Dobija', 'E', 2019),
(696, 'Kinga', 'Golec', 'E', 2019),
(697, 'Maja', 'Gut', 'E', 2019),
(698, 'Natasza', 'Guzik', 'E', 2019),
(699, 'Nikola', 'Jeziorska', 'E', 2019),
(700, 'Oliwia', 'Juraszek', 'E', 2019),
(701, 'Kamil', 'Koczur', 'E', 2019),
(702, 'Joanna', 'Krysta', 'E', 2019),
(703, 'Zuzanna', 'Krzak', 'E', 2019),
(704, 'Anna', 'Krzyżowska', 'E', 2019),
(705, 'Martyna', 'Kubik', 'E', 2019),
(706, 'Martyna', 'Kufel', 'E', 2019),
(707, 'Aleksander', 'Kulec', 'E', 2019),
(708, 'Inez', 'Nowak', 'E', 2019),
(709, 'Jokasta', 'Pysz', 'E', 2019),
(710, 'Filip', 'Rodak', 'E', 2019),
(711, 'Szymon', 'Sobczak', 'E', 2019),
(712, 'Maja', 'Sobocińska', 'E', 2019),
(713, 'Jan', 'Strojny', 'E', 2019),
(714, 'Monika', 'Synowiec', 'E', 2019),
(715, 'Weronika', 'Szczotka', 'E', 2019),
(716, 'Nikodem', 'Ścieszka', 'E', 2019),
(717, 'Julia', 'Ślósarczyk', 'E', 2019),
(718, 'Zuzanna', 'Świerczek', 'E', 2019),
(719, 'Giulia', 'Tonet', 'E', 2019),
(720, 'Aleksandra', 'Trela', 'E', 2019),
(721, 'Paulina', 'Wieczorek', 'E', 2019),
(722, 'Jakub', 'Witek', 'E', 2019),
(723, 'Dominika', 'Ziora', 'E', 2019),
(724, 'Julia', 'Zoń', 'E', 2019),
(725, 'Kacper', 'Żółty', 'E', 2019);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `efekt_uczniowie_do_oceny`
--
ALTER TABLE `efekt_uczniowie_do_oceny`
  ADD PRIMARY KEY (`id_ucznia`,`rok`,`semestr`);

--
-- Indeksy dla tabeli `godz_AktywnyOkres`
--
ALTER TABLE `godz_AktywnyOkres`
  ADD PRIMARY KEY (`ID_OkresRozliczeniowy`);

--
-- Indeksy dla tabeli `godz_Nauczyciele_Godziny`
--
ALTER TABLE `godz_Nauczyciele_Godziny`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `godz_Nauczyciele_klasy4`
--
ALTER TABLE `godz_Nauczyciele_klasy4`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_Nauczyciela` (`id_Nauczyciela`);

--
-- Indeksy dla tabeli `godz_Nauczyciele_Nadgodziny`
--
ALTER TABLE `godz_Nauczyciele_Nadgodziny`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `godz_Nauczyciele_Rozliczenie_Tydzien`
--
ALTER TABLE `godz_Nauczyciele_Rozliczenie_Tydzien`
  ADD PRIMARY KEY (`ID_rozliczenia`),
  ADD KEY `id_tydzien` (`id_tydzien`),
  ADD KEY `id_nauczyciel` (`id_nauczyciel`);

--
-- Indeksy dla tabeli `godz_Nauczyciele_Tydzien_old`
--
ALTER TABLE `godz_Nauczyciele_Tydzien_old`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `godz_okresRozliczeniowy`
--
ALTER TABLE `godz_okresRozliczeniowy`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `godz_passwords`
--
ALTER TABLE `godz_passwords`
  ADD PRIMARY KEY (`typKonta`);

--
-- Indeksy dla tabeli `godz_TydzienRozliczeniowy`
--
ALTER TABLE `godz_TydzienRozliczeniowy`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `miesiace`
--
ALTER TABLE `miesiace`
  ADD PRIMARY KEY (`miesiac`);

--
-- Indeksy dla tabeli `nagrody_typ`
--
ALTER TABLE `nagrody_typ`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `nagrody_wpisy`
--
ALTER TABLE `nagrody_wpisy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `Nauczyciele`
--
ALTER TABLE `Nauczyciele`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `Przedmioty`
--
ALTER TABLE `Przedmioty`
  ADD PRIMARY KEY (`przedmiot`);

--
-- Indeksy dla tabeli `RokSettings`
--
ALTER TABLE `RokSettings`
  ADD PRIMARY KEY (`rokSzk`,`semestr`);

--
-- Indeksy dla tabeli `uczniowie`
--
ALTER TABLE `uczniowie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `godz_Nauczyciele_Godziny`
--
ALTER TABLE `godz_Nauczyciele_Godziny`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `godz_Nauczyciele_klasy4`
--
ALTER TABLE `godz_Nauczyciele_klasy4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `godz_Nauczyciele_Nadgodziny`
--
ALTER TABLE `godz_Nauczyciele_Nadgodziny`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=628;

--
-- AUTO_INCREMENT for table `godz_Nauczyciele_Rozliczenie_Tydzien`
--
ALTER TABLE `godz_Nauczyciele_Rozliczenie_Tydzien`
  MODIFY `ID_rozliczenia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `godz_Nauczyciele_Tydzien_old`
--
ALTER TABLE `godz_Nauczyciele_Tydzien_old`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `godz_TydzienRozliczeniowy`
--
ALTER TABLE `godz_TydzienRozliczeniowy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `nagrody_typ`
--
ALTER TABLE `nagrody_typ`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `nagrody_wpisy`
--
ALTER TABLE `nagrody_wpisy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `Nauczyciele`
--
ALTER TABLE `Nauczyciele`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `uczniowie`
--
ALTER TABLE `uczniowie`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=726;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `godz_AktywnyOkres`
--
ALTER TABLE `godz_AktywnyOkres`
  ADD CONSTRAINT `godz_AktywnyOkres_ibfk_1` FOREIGN KEY (`ID_OkresRozliczeniowy`) REFERENCES `godz_okresRozliczeniowy` (`ID`);

--
-- Constraints for table `godz_Nauczyciele_klasy4`
--
ALTER TABLE `godz_Nauczyciele_klasy4`
  ADD CONSTRAINT `godz_Nauczyciele_klasy4_ibfk_1` FOREIGN KEY (`id_Nauczyciela`) REFERENCES `Nauczyciele` (`ID`);

--
-- Constraints for table `godz_Nauczyciele_Rozliczenie_Tydzien`
--
ALTER TABLE `godz_Nauczyciele_Rozliczenie_Tydzien`
  ADD CONSTRAINT `godz_Nauczyciele_Rozliczenie_Tydzien_ibfk_1` FOREIGN KEY (`id_tydzien`) REFERENCES `godz_TydzienRozliczeniowy` (`ID`),
  ADD CONSTRAINT `godz_Nauczyciele_Rozliczenie_Tydzien_ibfk_2` FOREIGN KEY (`id_nauczyciel`) REFERENCES `Nauczyciele` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
