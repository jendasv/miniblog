-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Stř 13. kvě 2020, 16:07
-- Verze serveru: 10.4.8-MariaDB
-- Verze PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `miniblog`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `comments`
--

CREATE TABLE `comments` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `post_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `text` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `post_id`, `text`, `created_at`) VALUES
(1, 11, 12, 'What an awesome post!', '2020-05-11 13:30:11'),
(2, 13, 12, 'Are you mad? It is a piece of junk!', '2020-05-11 13:35:11'),
(3, 11, 12, 'Shut up! You know nothing Jon Snow!', '2020-05-11 14:36:39'),
(4, 11, 12, 'I hope this is working. Please, this must be working :(', '2020-05-12 14:48:40'),
(5, 11, 6, 'What the hell does \"Ř\" mean? What language is that ? :(', '2020-05-12 14:51:57'),
(6, 23, 6, 'I think this is czech', '2020-05-12 14:54:53'),
(7, 11, 14, 'Pavel is the second after Chuck Norris!', '2020-05-12 18:13:29');

--
-- Spouště `comments`
--
DELIMITER $$
CREATE TRIGGER `comments_create` BEFORE INSERT ON `comments` FOR EACH ROW SET NEW.created_at = NOW()
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabulky `phpauth_attempts`
--

CREATE TABLE `phpauth_attempts` (
  `id` int(11) NOT NULL,
  `ip` char(39) NOT NULL,
  `expiredate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `phpauth_attempts`
--

INSERT INTO `phpauth_attempts` (`id`, `ip`, `expiredate`) VALUES
(38, '::1', '2020-05-13 16:04:17'),
(39, '::1', '2020-05-13 16:04:36'),
(40, '::1', '2020-05-13 16:05:37');

-- --------------------------------------------------------

--
-- Struktura tabulky `phpauth_config`
--

CREATE TABLE `phpauth_config` (
  `setting` varchar(100) NOT NULL,
  `value` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `phpauth_config`
--

INSERT INTO `phpauth_config` (`setting`, `value`) VALUES
('allow_concurrent_sessions', '0'),
('attack_mitigation_time', '+30 minutes'),
('attempts_before_ban', '30'),
('attempts_before_verify', '5'),
('bcrypt_cost', '10'),
('cookie_domain', NULL),
('cookie_forget', '+30 minutes'),
('cookie_http', '0'),
('cookie_name', 'phpauth_session_cookie'),
('cookie_path', '/'),
('cookie_remember', '+1 month'),
('cookie_renew', '+5 minutes'),
('cookie_secure', '0'),
('emailmessage_suppress_activation', '0'),
('emailmessage_suppress_reset', '0'),
('mail_charset', 'UTF-8'),
('password_min_score', '0'),
('recaptcha_enabled', '0'),
('recaptcha_secret_key', ''),
('recaptcha_site_key', ''),
('request_key_expiration', '+10 minutes'),
('site_activation_page', 'activate'),
('site_email', NULL),
('site_key', 'fghuior.)/!/jdUkd8s2!7HVHG7777ghg'),
('site_language', 'en_GB'),
('site_name', 'miniblog'),
('site_password_reset_page', 'create-new-password'),
('site_timezone', 'Europe/Paris'),
('site_url', 'http://localhost/miniblog'),
('smtp', '1'),
('smtp_auth', '1'),
('smtp_debug', '1'),
('smtp_host', ''),
('smtp_password', ''),
('smtp_port', ''),
('smtp_security', ''),
('smtp_username', NULL),
('table_attempts', 'phpauth_attempts'),
('table_emails_banned', 'phpauth_emails_banned'),
('table_requests', 'phpauth_requests'),
('table_sessions', 'phpauth_sessions'),
('table_translations', 'phpauth_translation_dictionary'),
('table_users', 'phpauth_users'),
('translation_source', 'php'),
('verify_email_max_length', '100'),
('verify_email_min_length', '5'),
('verify_email_use_banlist', '1'),
('verify_password_min_length', '3');

-- --------------------------------------------------------

--
-- Struktura tabulky `phpauth_emails_banned`
--

CREATE TABLE `phpauth_emails_banned` (
  `id` int(11) NOT NULL,
  `domain` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `phpauth_requests`
--

CREATE TABLE `phpauth_requests` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `token` char(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `expire` datetime NOT NULL,
  `type` enum('activation','reset') CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabulky `phpauth_sessions`
--

CREATE TABLE `phpauth_sessions` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `hash` char(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `expiredate` datetime NOT NULL,
  `ip` varchar(39) NOT NULL,
  `agent` varchar(200) NOT NULL,
  `cookie_crc` char(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `phpauth_sessions`
--

INSERT INTO `phpauth_sessions` (`id`, `uid`, `hash`, `expiredate`, `ip`, `agent`, `cookie_crc`) VALUES
(41, 11, 'ae2de492699dd5684eef1abf0d86d80378813b44', '2020-06-13 15:52:56', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36', '2ef5ab92537a0b3f3396f56b5f01788c085aef0c');

-- --------------------------------------------------------

--
-- Struktura tabulky `phpauth_users`
--

CREATE TABLE `phpauth_users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) CHARACTER SET utf16 NOT NULL,
  `authority` enum('admin','editor','user') NOT NULL DEFAULT 'user',
  `status` enum('Access granted','Access denied','','') NOT NULL DEFAULT 'Access granted',
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `isactive` tinyint(1) NOT NULL DEFAULT 0,
  `dt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `phpauth_users`
--

INSERT INTO `phpauth_users` (`id`, `email`, `user_name`, `authority`, `status`, `password`, `isactive`, `dt`) VALUES
(11, 'terminator@gmail.com', 'terminator', 'admin', 'Access granted', '$2y$10$ULF0ApJYVxuAnnNQk2QwTeCU2ijCJKpkFr05cx.EPhi8RUv5VCcXi', 1, '2020-04-20 12:28:11'),
(13, 'senator@gmail.com', 'senator', 'user', 'Access granted', '$2y$10$RDmuB8Zp6rCL4zwef8S1FOCKbKZyAoF9RifZL41nwh6.KWuM3tkCi', 1, '2020-04-21 21:02:30'),
(23, 'traktor@gmail.com', 'traktor', 'user', 'Access granted', '$2y$10$yJwn3dOPWyqSe1c30oiYp.b9Xw5b7Ix7lE99rQk1Mn1OHrj1P6vPW', 1, '2020-04-27 19:24:57');

-- --------------------------------------------------------

--
-- Struktura tabulky `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `title` varchar(200) NOT NULL DEFAULT '',
  `text` text NOT NULL,
  `slug` varchar(200) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `title`, `text`, `slug`, `created_at`, `updated_at`) VALUES
(2, 11, 'Ego Tripping At The Gates Of Hell', 'I was waiting on a moment\r\nBut the moment never came\r\nAll the billion other moments\r\nWere just slipping all away\r\n(I must have been tripping) Were just slipping all away\r\n(Just ego tripping)\r\n\r\nI was wanting you to love me\r\nBut your love, it never came\r\nAll the other love around me\r\nWas just wasting all away\r\n(I must have been tripping) Was just wasting all away\r\n(Just ego tripping) Was just wasting all away\r\n(Must have been trip—)\r\n\r\nI was waiting on a moment\r\nBut the moment never came\r\nBut the moment never came\r\n\r\n(Must have been tripping) But the moment never came\r\n(Just ego tripping) But the moment never came\r\n\r\nhttp://genius.com/The-flaming-lips-ego-tripping-at-the-gates-of-hell-lyrics', 'ego-tripping-at-the-gates-of-hell', '2015-07-29 15:26:38', '2020-04-21 09:29:37'),
(3, 11, 'The Prince and the Pauper', 'In the ancient city of London, on a certain autumn day in the second quarter of the sixteenth century, a boy was born to a poor family of the name of Canty, who did not want him. On the same day another English child was born to a rich family of the name of Tudor, who did want him. All England wanted him too. England had so longed for him, and hoped for him, and prayed God for him, that, now that he was really come, the people went nearly mad for joy. Mere acquaintances hugged and kissed each other and cried. Everybody took a holiday, and high and low, rich and poor, feasted and danced and sang, and got very mellow; and they kept this up for days and nights together.\r\n\r\nBy day, London was a sight to see, with gay banners waving from every balcony and housetop, and splendid pageants marching along. By night, it was again a sight to see, with its great bonfires at every corner, and its troops of revellers making merry around them. There was no talk in all England but of the new baby, Edward Tudor, Prince of Wales, who lay lapped in silks and satins, unconscious of all this fuss, and not knowing that great lords and ladies were tending him and watching over him—and not caring, either.  But there was no talk about the other baby, Tom Canty, lapped in his poor rags, except among the family of paupers whom he had just come to trouble with his presence.\r\n\r\nLet us skip a number of years.\r\n\r\nLondon was fifteen hundred years old, and was a great town—for that day. It had a hundred thousand inhabitants—some think double as many.  The streets were very narrow, and crooked, and dirty, especially in the part where Tom Canty lived, which was not far from London Bridge.  The houses were of wood, with the second story projecting over the first, and the third sticking its elbows out beyond the second.  The higher the houses grew, the broader they grew.  They were skeletons of strong criss-cross beams, with solid material between, coated with plaster.  The beams were painted red or blue or black, according to the owner\'s taste, and this gave the houses a very picturesque look.  The windows were small, glazed with little diamond-shaped panes, and they opened outward, on hinges, like doors.\r\n\r\nThe house which Tom\'s father lived in was up a foul little pocket called Offal Court, out of Pudding Lane.  It was small, decayed, and rickety, but it was packed full of wretchedly poor families. Canty\'s tribe occupied a room on the third floor.  The mother and father had a sort of bedstead in the corner; but Tom, his grandmother, and his two sisters, Bet and Nan, were not restricted—they had all the floor to themselves, and might sleep where they chose.  There were the remains of a blanket or two, and some bundles of ancient and dirty straw, but these could not rightly be called beds, for they were not organised; they were kicked into a general pile, mornings, and selections made from the mass at night, for service.', 'the-prince-the-pauper', '2015-07-29 15:14:09', '2020-04-28 19:44:19'),
(6, 11, 'Řeřicha je rostlina čeledi čo já nevím', 'Řeřicha se vyskytuje zejména v povodí řek, můžeme ji nalézt i na polích nebo v lesích, kde byl původně potok, bažina nebo jiné místo s vlhkou půdou. Je také možné ji nalézt pod vodní hladinou, není to ale typické pro tuto rostlinu. Vyskytuje se téměř po celém světě (kromě pouští a polopouští). V jiných zemích má příbuzná rostlina jiný název.', 'rericha-je-rostlina-celedi-co-ja-nevim', '2020-04-14 20:35:19', '2020-04-21 09:29:37'),
(12, 11, 'This is a title', 'Marzipan sweet roll muffin biscuit candy sugar plum. Candy canes soufflé sesame snaps muffin jelly-o jelly macaroon carrot cake. Biscuit sweet roll dragée. Sweet jujubes chupa chups chupa chups tiramisu sweet roll. Biscuit bear claw topping cake macaroon cookie tiramisu marzipan croissant. Fruitcake macaroon cake brownie oat cake dessert chocolate bar pudding biscuit.\r\n\r\nhttps://www.youtube.com/watch?v=vORsKyopHyM&index=48&list=FLa2et\r\n\r\nPie bear claw cheesecake wafer pie jujubes dessert. Jelly-o lollipop dessert cake brownie jelly-o muffin tiramisu oat cake. Marshmallow carrot cake jujubes marshmallow chocolate cake sesame snaps muffin. Muffin icing marshmallow lemon drops dessert danish cake halvah muffin. Icing chocolate cake. Pudding pie macaroon fruitcake bear claw cheesecake pudding soufflé. Pie donut carrot cake cupcake muffin.\r\n\r\nhttps://youtu.be/LKxWl4PcBY4\r\n\r\nPudding tootsie roll wafer candy croissant cake dessert. Jelly-o croissant ice cream sesame snaps bear claw tiramisu. Caramels marzipan sugar plum sweet roll donut dragée. Fruitcake cupcake cake.', 'this-is-a-title', '2020-04-28 19:43:14', '2020-04-28 19:43:58'),
(14, 11, 'Pavel Tsatsouline', 'Pavel Tsatsouline, (Belarusian: Павел Цацулін, romanized: Paveł Caculin; born 23 August 1969 in Minsk, USSR) is the Chairman of StrongFirst, Inc., a fitness instructor who has introduced SPETSNAZ training techniques from the former Soviet Union to US Navy SEALs , Marines and Army Special Forces, and shortly thereafter to the American public.\r\n\r\nTsatsouline is particularly notable for popularizing the kettlebell in the modern era in the West, most notably through his books and through a series of instructional videos, delivered with his trademark comedic intent, comically exploiting Russian stereotypes with a thick accent, a dungeon-esque setting, and frequent use of the word \"comrade\". Vic Sussman among others praised Tsatsouline\'s videos because their power as training tools in part stemmed from the emphasis on kettlebells as fun. Pavel\'s strength training exercises were soley focused on practical strength and mobility. For him bigger did not always mean stronger.\r\n\r\nHe holds a degree in Sports Science from the Physical Culture Institute in Minsk. He is involved with the evolving field of martial arts fitness and is a proponent of the kettlebell as an exercise and strengthening tool. In 1998, Tsatsouline became a kettlebell instructor in the United States.\r\n\r\nTsatsouline claims to have been a PT drill instructor for Spetsnaz, the elite Soviet special forces unit, during the late 1980s (when Tsatsouline was in his teenage years).\r\n\r\nIn 2001, Tsatsouline was voted a \"Hot Trainer\" by Rolling Stone, pictured with a kettlebell in hand. He was considered the father of the kettle bell and popularized the usage of kettle bell exercise to increase strength. He has published articles in Milo magazine and Performance Press, as well as being the author of several books on stretching and strength training .\r\n\r\nIn 2012, Pavel left the RKC and formed a new company, StrongFirst.', 'pavel-tsatsouline', '2020-05-12 18:07:10', '2020-05-12 18:12:26');

--
-- Spouště `posts`
--
DELIMITER $$
CREATE TRIGGER `posts_create` BEFORE INSERT ON `posts` FOR EACH ROW SET NEW.created_at = NOW(), NEW.updated_at = NOW()
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `posts_update` BEFORE UPDATE ON `posts` FOR EACH ROW SET NEW.updated_at = NOW(), NEW.created_at = OLD.created_at
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabulky `posts_tags`
--

CREATE TABLE `posts_tags` (
  `post_id` int(11) UNSIGNED NOT NULL DEFAULT 0,
  `tag_id` int(11) UNSIGNED NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `posts_tags`
--

INSERT INTO `posts_tags` (`post_id`, `tag_id`) VALUES
(3, 1),
(14, 8),
(14, 11),
(12, 1),
(12, 6),
(12, 10),
(2, 6);

-- --------------------------------------------------------

--
-- Struktura tabulky `tags`
--

CREATE TABLE `tags` (
  `id` int(11) UNSIGNED NOT NULL,
  `tag` varchar(60) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `tags`
--

INSERT INTO `tags` (`id`, `tag`) VALUES
(1, 'balls'),
(6, 'stick'),
(8, 'dumbass'),
(10, 'greenhorn'),
(11, 'monkey');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Klíče pro tabulku `phpauth_attempts`
--
ALTER TABLE `phpauth_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`);

--
-- Klíče pro tabulku `phpauth_config`
--
ALTER TABLE `phpauth_config`
  ADD UNIQUE KEY `setting` (`setting`);

--
-- Klíče pro tabulku `phpauth_emails_banned`
--
ALTER TABLE `phpauth_emails_banned`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `phpauth_requests`
--
ALTER TABLE `phpauth_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `token` (`token`),
  ADD KEY `uid` (`uid`);

--
-- Klíče pro tabulku `phpauth_sessions`
--
ALTER TABLE `phpauth_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `phpauth_users`
--
ALTER TABLE `phpauth_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`),
  ADD KEY `id` (`id`);

--
-- Klíče pro tabulku `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Klíče pro tabulku `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Klíče pro tabulku `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `phpauth_attempts`
--
ALTER TABLE `phpauth_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pro tabulku `phpauth_emails_banned`
--
ALTER TABLE `phpauth_emails_banned`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `phpauth_requests`
--
ALTER TABLE `phpauth_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pro tabulku `phpauth_sessions`
--
ALTER TABLE `phpauth_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pro tabulku `phpauth_users`
--
ALTER TABLE `phpauth_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pro tabulku `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `posts_tags`
--
ALTER TABLE `posts_tags`
  ADD CONSTRAINT `fk_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tags` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
