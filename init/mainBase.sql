-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Erstellungszeit: 09. Jul 2021 um 11:16
-- Server-Version: 10.5.11-MariaDB-1:10.5.11+maria~focal
-- PHP-Version: 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mainBase`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `articles`
--

CREATE TABLE `articles` (
  `ID` int(11) NOT NULL,
  `text` varchar(4096) NOT NULL,
  `userID` int(11) NOT NULL,
  `themeID` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `pictureID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `articles`
--

INSERT INTO `articles` (`ID`, `text`, `userID`, `themeID`, `date`, `pictureID`) VALUES
(9, 'Da schließe ich mich mal an.', 1, 37, '07.07.2021', NULL),
(10, 'Ich weiß, dass es in der Krone einen Guten Braten gibt, aber selber machen ist schwierig.', 1, 37, '07.07.2021', NULL),
(11, 'Ich habe das gefunden. Vielleicht hilft es dir weiter!', 1, 38, '07.07.2021', 21),
(13, 'Hallo ich finde den Braten auch cool.\r\n\r\nAka: Anton', 1, 37, '07.07.2021', 31),
(14, 'Ich bräuchte auch ein Rezept.', 1, 48, '08.07.2021', NULL),
(15, 'Zutaten für 4\r\nPortionen\r\n1	Aubergine(n)\r\nOlivenöl\r\n4	Burgerbrötchen, alternativ Vollkornbrötchen oder Baguettebrötchen\r\n2       große	Tomate(n)\r\n1	Avocado(s), reif\r\n1       Zehe/n	Knoblauch\r\n100 g	Joghurt\r\n3 EL	Mayonnaise\r\n1 Spritzer	Tabasco, grün\r\nSalz und Pfeffer, schwarzer\r\neinige	Salatblätter\r\n\r\n\r\nZubereitung\r\nArbeitszeit ca. 20 Minuten\r\nKoch-/Backzeit ca. 10 Minuten\r\nGesamtzeit ca. 30 Minuten\r\nDie Aubergine waschen, längs in Scheiben schneiden und im heißen Öl von beiden Seiten goldbraun braten.\r\n\r\nWährenddessen die Brötchen halbieren. Die Tomaten und die geschälte Avocado in dicke Scheiben schneiden und leicht salzen.\r\n\r\nDen Knoblauch pressen oder sehr fein hacken und mit Joghurt, Mayonnaise, Tabasco, Salz und Pfeffer glatt rühren. Beide Brötchenhälften damit bestreichen.\r\n\r\nDie untere Hälfte zuerst mit Salat, dann je zwei Auberginen-, Avocado- und Tomatenscheiben belegen und mit der oberen Brötchenhälfte bedecken. Eventuell mit Holzspießchen zusammenstecken.\r\n\r\nDieses Rezept lässt sich auch variieren, z. B. mit gebratenen Riesenchampignonscheiben oder gegrillten Zucchinischeiben.', 1, 48, '08.07.2021', 35),
(16, 'Aber ich finde du solltest lieber über Burger nachdenken.', 12, 37, '08.07.2021', NULL),
(17, 'Das sieht sehr lecker aus!\r\nMuss ich nachher gleich ausprobieren!', 14, 47, '08.07.2021', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `picture`
--

CREATE TABLE `picture` (
  `ID` int(11) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `name` varchar(255) NOT NULL,
  `sizeKB` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `picture`
--

INSERT INTO `picture` (`ID`, `url`, `name`, `sizeKB`, `height`, `width`) VALUES
(20, '1251.jpg', 'Bild zum Thema Braten', 364836, 455, 1400),
(21, 'Infografik Pizza Report 2018 Copyright pizza.de.jpg.jpg', 'Bild', 202192, 1200, 1199),
(30, 'buddha-bowl-mit-kokos-puten-streifen.jpg', 'Bild zum Thema Budda Bowl', 65631, 400, 600),
(31, 'essen_diabetes__Africa_Studio_-_Fotolia_126049573-9570ca1934012ad80251980e889216.jpg', 'Bild', 145867, 630, 1200),
(34, 'burger.jpg', 'Bild zum Thema Burger', 166047, 675, 1200),
(35, 'tomaten-auberginen-avocado-burger.jpg', 'Bild', 61755, 400, 600);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `themes`
--

CREATE TABLE `themes` (
  `ID` int(11) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `description` varchar(4096) NOT NULL,
  `userID` int(11) NOT NULL,
  `views` int(11) DEFAULT 0,
  `answers` int(11) DEFAULT 0,
  `lastChange` varchar(255) DEFAULT NULL,
  `pictureID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `themes`
--

INSERT INTO `themes` (`ID`, `headline`, `description`, `userID`, `views`, `answers`, `lastChange`, `pictureID`) VALUES
(37, 'Braten', 'Hat jemand eine Idee für einen guten und leckeren Braten. Er sollte nicht zu schwer zu kochen sein aber ich würde gerne mal einen selber machen.', 1, 112, 0, '07.07.2021', 20),
(38, 'Pizza mit Ananas', 'Ich habe mich schon öfters gefragt, wie viele Menschen Ananas auf der Pizza mögen. Wie sieht es bei euch aus?', 1, 41, 0, '07.07.2021', NULL),
(47, 'Budda Bowl', 'Zutaten für 4 Portionen\r\n1 Gurke(n)\r\n2 kleine Rote Bete, gekocht\r\n1 Mango(s)\r\n400 g d’aucy Duo-Quinoa\r\n4 Handvoll Babyspinat\r\n250 g d’aucy Kichererbsen\r\n200 g d’aucy Sonnenmais\r\n200 g d’aucy Kidneybohnen\r\nAußerdem:\r\n1 Bio-Limette(n)\r\n200 ml Kokosmilch, ungesüßt\r\n300 g Putenbrustfilet(s)\r\n50 g Mehl\r\n100 g Kokosflocken\r\n2 EL Kokosöl\r\n4 Stiel/e Koriander\r\nSalz und Pfeffer\r\nFür das Dressing:\r\n100 ml Kokosmilch\r\n2 EL Sojasauce\r\n\r\nZubereitung\r\nArbeitszeit ca. 20 Minuten\r\nKoch-/Backzeit ca. 15 Minuten\r\nGesamtzeit ca. 35 Minuten\r\nDie Gurke gut waschen. Mithilfe eines Spiralschneiders zu Spaghetti drehen. Die Roten Bete in kleine Würfel schneiden. Die Mango schälen und würfeln.\r\n\r\nDuo-Quinoa mit dem Spinat auf vier Schüsseln verteilen. Die Kichererbsen, Sonnenmais und Kidneybohnen darauf geben. Die Gurken-Spaghetti, Rote Bete- und Mangowürfel dazugeben.\r\n\r\nDie Limette waschen, die Schale fein abreiben und den Saft auspressen. Die Hälfte des Limettensaftes mit 200 ml Kokosmilch und der Limettenschale verrühren.\r\n\r\nDie Putenbrust in Streifen schneiden und auf 4 lange Spieße stecken. Zuerst im Mehl, dann in der Kokosmilch und zuletzt in den Kokosflocken wenden. Das Kokosöl in einer Pfanne erhitzen und die Spieße darin von allen Seiten knusprig anbraten.\r\n\r\nFür das Dressing 100 ml Kokosmilch mit 2 EL Sojasauce und 2 EL von dem restlichen Limettensaft verquirlen und mit Salz und Pfeffer würzen. Über die Bowls träufeln und zum Schluss die Puten-Spieße darauflegen. Mit frisch gehacktem Koriander bestreuen und mit Salz und Pfeffer würzen.\r\n', 1, 22, 0, '07.07.2021', 30),
(48, 'Burger', 'Ich suche nach einem Burger Rezept', 1, 3, 0, '08.07.2021', 34);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `userName` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`ID`, `userName`, `password`) VALUES
(1, 'Gast', ''),
(12, 'Tom', '123'),
(14, 'Vilas', 'Passwort');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `themeID` (`themeID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `pictureID` (`pictureID`);

--
-- Indizes für die Tabelle `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `userID` (`userID`),
  ADD KEY `pictureID` (`pictureID`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `articles`
--
ALTER TABLE `articles`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT für Tabelle `picture`
--
ALTER TABLE `picture`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT für Tabelle `themes`
--
ALTER TABLE `themes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`themeID`) REFERENCES `themes` (`ID`),
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `articles_ibfk_3` FOREIGN KEY (`pictureID`) REFERENCES `picture` (`ID`);

--
-- Constraints der Tabelle `themes`
--
ALTER TABLE `themes`
  ADD CONSTRAINT `themes_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `themes_ibfk_2` FOREIGN KEY (`pictureID`) REFERENCES `picture` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
