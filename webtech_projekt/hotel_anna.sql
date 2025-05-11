-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2025. Máj 11. 19:23
-- Kiszolgáló verziója: 10.4.21-MariaDB
-- PHP verzió: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `hotel_anna`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `adminok`
--

CREATE TABLE `adminok` (
  `id` int(11) NOT NULL,
  `felhasznalonev` varchar(50) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `jelszo_hash` varchar(255) COLLATE utf8mb4_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `adminok`
--

INSERT INTO `adminok` (`id`, `felhasznalonev`, `jelszo_hash`) VALUES
(1, 'admin', '$2y$10$lUO.15LmjZoQ1txMQLYAYeEJdrLGQhQlgF0dqWuiq3CtvutzkP3WO');

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `foglalasok`
--

CREATE TABLE `foglalasok` (
  `id` int(11) NOT NULL,
  `nev` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_hungarian_ci NOT NULL,
  `szobatipus` enum('classic','terasz','csaladi','lakosztaly') COLLATE utf8mb4_hungarian_ci NOT NULL,
  `vendegszam` tinyint(4) NOT NULL,
  `erkezes_datum` date NOT NULL,
  `tavozas_datum` date NOT NULL,
  `foglalas_idopontja` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_hungarian_ci;

--
-- A tábla adatainak kiíratása `foglalasok`
--

INSERT INTO `foglalasok` (`id`, `nev`, `email`, `szobatipus`, `vendegszam`, `erkezes_datum`, `tavozas_datum`, `foglalas_idopontja`) VALUES
(1, 'Horváth Zoltán', 'horvathzoltan@gmail.com', 'terasz', 2, '2025-05-28', '2025-05-30', '0000-00-00 00:00:00'),
(9, 'Horváth Zoltánné', 'horvathzoltanne@gmail.com', 'lakosztaly', 2, '2025-05-13', '2025-05-29', '0000-00-00 00:00:00'),
(11, 'Czéhmester Anna', 'czehmesteranna2005@freemail.hu', 'classic', 1, '2025-05-13', '2025-05-16', '0000-00-00 00:00:00');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `adminok`
--
ALTER TABLE `adminok`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `felhasznalonev` (`felhasznalonev`);

--
-- A tábla indexei `foglalasok`
--
ALTER TABLE `foglalasok`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `adminok`
--
ALTER TABLE `adminok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT a táblához `foglalasok`
--
ALTER TABLE `foglalasok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
