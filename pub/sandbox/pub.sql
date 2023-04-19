-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Kwi 2023, 16:12
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `pub`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cos`
--

CREATE TABLE `cos` (
  `id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `filename` char(96) NOT NULL,
  `tytul` text NOT NULL,
  `autor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `cos`
--

INSERT INTO `cos` (`id`, `timestamp`, `filename`, `tytul`, `autor`) VALUES
(7, '2023-04-19 16:10:26', 'img/17cbde10da8f8ad1e14af9724e40c8a942e8ceeaca5510a26ad17ce27751a582.webp', 'ok', 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `glos`
--

CREATE TABLE `glos` (
  `id` int(11) NOT NULL,
  `down_votes` int(11) NOT NULL,
  `up_votes` int(11) NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `emeil` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user`
--

INSERT INTO `user` (`id`, `emeil`, `password`) VALUES
(3, 'ok@abc.pl', '$argon2i$v=19$m=65536,t=4,p=1$bmVJQzJVM3FsOXJvSGdzWg$ZxFP5s9yvcMjtEnf9DzVW8b2/cGyL0E2w2GkR0FCHkQ');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `cos`
--
ALTER TABLE `cos`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `glos`
--
ALTER TABLE `glos`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`emeil`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `cos`
--
ALTER TABLE `cos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `glos`
--
ALTER TABLE `glos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
