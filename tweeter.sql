-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 09 Lut 2016, 19:21
-- Wersja serwera: 5.5.44-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `tweeter`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tweet_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` varchar(60) COLLATE utf8_polish_ci NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tweet_id` (`tweet_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=31 ;

--
-- Zrzut danych tabeli `Comments`
--

INSERT INTO `Comments` (`id`, `tweet_id`, `user_id`, `comment_text`, `comment_date`) VALUES
(1, 19, 4, 'i co tak piszesz', '2016-01-30 22:07:25'),
(2, 19, 6, 'i co tak piszesz cooooo 6', '2016-01-30 22:07:59'),
(3, 19, 1, 'bjbjbjhj', '2016-01-31 11:36:14'),
(4, 19, 1, 'bjbjbjhj', '2016-01-31 11:36:14'),
(5, 19, 1, 'bjbjbjhj', '2016-01-31 11:38:55'),
(6, 19, 1, 'bjbjbjhj', '2016-01-31 11:38:55'),
(7, 15, 1, 'bjbjbjhj', '2016-01-31 11:40:02'),
(8, 15, 1, 'komentuje hops hops', '2016-01-31 11:40:18'),
(9, 6, 1, 'komentuje hops hops', '2016-01-31 11:40:58'),
(10, 6, 1, 'komentuje hops hops', '2016-01-31 11:41:11'),
(11, 6, 1, 'komentuje lecimy na miasto', '2016-01-31 11:41:14'),
(12, 17, 6, 'komentuje lecimy na miasto', '2016-01-31 11:42:55'),
(13, 17, 6, 'komentuje lecimy na miasto', '2016-01-31 11:43:05'),
(14, 17, 6, 'komentuje lecimy na miasto', '2016-01-31 11:43:09'),
(15, 17, 6, 'Hej hej heloo³', '2016-01-31 11:49:55'),
(16, 4, 6, 'No hej hej hej :):):)', '2016-01-31 11:50:28'),
(17, 19, 6, 'Lol lol tutaj Anna', '2016-01-31 14:56:01'),
(18, 19, 6, 'yhym test tu anna', '2016-01-31 14:58:10'),
(19, 19, 6, 'yhym test tu anna', '2016-01-31 14:58:57'),
(20, 19, 6, 'yhym test tu anna', '2016-01-31 14:59:58'),
(21, 19, 6, 'yhym test tu anna', '2016-01-31 15:00:12'),
(22, 19, 1, 'Where is my Jackie', '2016-02-02 21:48:34'),
(23, 19, 1, 'yhy yhy', '2016-02-08 11:36:50'),
(24, 27, 1, 'Te¿ idê dzisiaj ! :)', '2016-02-09 18:07:20'),
(25, 27, 1, 'Jakie wra¿enia?', '2016-02-09 18:08:50'),
(26, 6, 1, 'I jak tam by³o?', '2016-02-09 18:28:52'),
(27, 27, 4, 'wow te¿ chcê', '2016-02-09 18:32:55'),
(28, 27, 7, 'To kiedy lecimy?', '2016-02-09 19:13:25'),
(29, 6, 7, 'jak tam fajnie?', '2016-02-09 19:14:18'),
(30, 30, 8, 'Ale walka', '2016-02-09 19:15:32');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Messages`
--

CREATE TABLE IF NOT EXISTS `Messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `send_id` int(11) NOT NULL,
  `receive_id` int(11) NOT NULL,
  `message_text` varchar(200) COLLATE utf8_polish_ci NOT NULL,
  `message_date` datetime NOT NULL,
  `opened` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `send_id` (`send_id`),
  KEY `receive_id` (`receive_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=21 ;

--
-- Zrzut danych tabeli `Messages`
--

INSERT INTO `Messages` (`id`, `send_id`, `receive_id`, `message_text`, `message_date`, `opened`) VALUES
(1, 1, 6, 'No hej Anna co tam', '2016-02-07 08:14:38', 0),
(2, 1, 4, 'HEj co tam', '2016-02-07 07:30:09', 0),
(3, 6, 1, 'no hej agat co tam', '2016-02-08 10:36:14', 0),
(4, 1, 6, 'No hej Anna. Wszystko fajnie :)', '2016-02-08 22:36:04', 0),
(5, 6, 1, 'No hej Agata. Wszystko fajnie :)', '2016-02-08 22:37:35', 1),
(6, 6, 1, 'Do zobaczniea Agata', '2016-02-08 22:39:36', 0),
(7, 6, 1, 'Pa Agata', '2016-02-08 22:40:42', 0),
(8, 1, 6, 'Lorem ipsum. By³am by³e¶ byli¶my. on ona ono. trzydzie¶ci znaków test musi byæ. co tam u ciebie', '2016-02-09 11:31:02', 1),
(9, 1, 6, 'No hej Anka. Jak tam leci wszysrtko super ekstra fajnie yolo?', '2016-02-09 12:07:46', 1),
(10, 1, 4, 'Hej Drake. Dawno nie pisa³e¶. Co slychaæ w Koziomitetkowlkadjwie?', '2016-02-09 12:12:53', 0),
(11, 9, 1, 'Hej Agata. Tutaj Sasza. Chcesz i¶æ do kina?', '2016-02-09 16:00:18', 1),
(12, 9, 1, 'Hej Agata. Co u Ciebie? :)', '2016-02-09 17:50:15', 0),
(13, 1, 9, 'No hej Sasza wszystko fajnie', '2016-02-09 18:29:39', 1),
(14, 4, 1, 'No hej Agata. wszystko super fajnie ', '2016-02-09 18:34:05', 1),
(15, 7, 1, 'Hej Agata. Co tam?', '2016-02-09 19:11:04', 1),
(16, 7, 9, 'Hej Sasza co tam?', '2016-02-09 19:11:23', 1),
(17, 8, 1, 'Hej Agata co tam?', '2016-02-09 19:15:51', 1),
(18, 8, 6, 'Hej Anna. Co tam u Ciebie?', '2016-02-09 19:16:14', 1),
(19, 8, 5, 'Hej Ewa co tam?', '2016-02-09 19:16:37', 1),
(20, 10, 1, 'Hej Agata. Jestem tu nowa', '2016-02-09 19:17:31', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Tweets`
--

CREATE TABLE IF NOT EXISTS `Tweets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `tweet_text` varchar(140) COLLATE utf8_polish_ci NOT NULL,
  `tweet_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=33 ;

--
-- Zrzut danych tabeli `Tweets`
--

INSERT INTO `Tweets` (`id`, `user_id`, `tweet_text`, `tweet_date`) VALUES
(1, 1, 'Hej to jaaaaa co s³ychaæ', '2016-01-29 14:36:30'),
(2, 1, 'Jestem w Warszawie. Czas wyj¶æ na miastoo', '2016-01-30 18:00:00'),
(3, 1, 'hej hej ale piêknie ¶wieci s³oñce', '2016-01-30 13:20:55'),
(4, 1, 'Ale nudna ta lekcja historii.', '2016-01-30 15:30:20'),
(5, 6, 'Lecimy na miastio', '2016-01-29 16:16:12'),
(6, 6, 'Lecimy na miastio', '2016-01-29 16:16:12'),
(10, 1, 'elson', '2016-01-30 05:31:41'),
(13, 1, 'Bukaa ciê widzi i buka ciê zje', '2016-01-30 05:38:55'),
(15, 1, 'hops hops', '2016-01-30 05:43:55'),
(16, 1, 'Pamparam', '2016-01-28 07:48:45'),
(17, 1, 'Koncert Ich Troje by³ super', '2016-01-30 17:53:19'),
(19, 1, 'S³abo poszed³ mi ten egzamin :(', '2016-01-30 18:57:08'),
(27, 9, 'W³a¶nie wyszed³em z nowego filmu Bonda. Ale czad!! :) By³o super ekstra super', '2016-02-09 15:38:55'),
(28, 1, 'W ¿yciu piêkne s± tylko chwile', '2016-02-09 18:15:12'),
(29, 4, 'Uczymy siê :((', '2016-02-09 18:32:24'),
(30, 7, 'Ogl±damy 1 z 10 :) Go go power rangers', '2016-02-09 19:07:22'),
(31, 8, 'Ciemno ju¿', '2016-02-09 19:15:18'),
(32, 10, 'Ale fajnie tutaj', '2016-02-09 19:17:46');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  `password` char(60) COLLATE utf8_polish_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=11 ;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`id`, `name`, `email`, `password`, `description`) VALUES
(1, 'Agata', 'test@test.pl', '$2y$11$PnPPCkvgHwHlv/37znojO.NrANIIhP2tOZaIEr8aEk6SylEQ7Hl2u', 'Najnowszy nowszy opis Agaty. has³o: 12345 '),
(4, 'Drake', 'Drass@wp.pl', '$2y$11$NOCJFM.3wJsY1KcddW500us.z7q5qL9Iv0HvBR6Fp1rgXfRvWbeuy', 'Hej to ja Drake. 12345'),
(5, 'Ewa', 'lokator@gmail.com', '$2y$11$UHze0NPRZLdohzuWlDVq5.BV.AGABmrjvsoI6FUl3Bedhd4/8u.da', 'Hej jestem Ewa.'),
(6, 'Anna', 'anna@gmail.pl', '$2y$11$P6HPX9/07Pv2J6idB9gP2uPKy9wbZ/3nPa39VDRyOsOvemiYiEFEu', 'turkawka'),
(7, 'Rafal', 'rafal@onet.pl', '$2y$11$F9y6tNPS1Z.qy480E4/MO.seVPKXAMYuJ466gThZDsAF8LdRN.9UW', 'Jestem Ronald. 12345 Nic nie robiê'),
(8, 'Leszek', 'leszek@gmail.com', '$2y$11$gUhqL/oj6KkLR6hvKOrzreQ60SRu9II88gteb1B6uGAbMB04dUx66', '12345. Jestem Leszek'),
(9, 'Sasza', 'sasza@wp.pl', '$2y$11$7Y35mpH4mfrzf5/zT3MbX.T3FygzA1AC7UxGd2105Ak7BJAldjZAK', 'Mam na imiê Szasza. Wo³aj± na mnie Sasz. Mam 15 lat. Lubiê je¼dziæ na deskorolce.'),
(10, 'Alina', 'ala@wp.pl', '$2y$11$YYSuBvprIy.lJb3nCJdKY.aVtiFkHGafiP337KeeKoSDjcuvvXPg.', '12345');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `Tweets` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Ograniczenia dla tabeli `Messages`
--
ALTER TABLE `Messages`
  ADD CONSTRAINT `Messages_ibfk_1` FOREIGN KEY (`send_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `Messages_ibfk_2` FOREIGN KEY (`receive_id`) REFERENCES `Users` (`id`);

--
-- Ograniczenia dla tabeli `Tweets`
--
ALTER TABLE `Tweets`
  ADD CONSTRAINT `Tweets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
