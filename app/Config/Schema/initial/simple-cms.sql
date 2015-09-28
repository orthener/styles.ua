-- phpMyAdmin SQL Dump
-- version 3.4.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 17 Sty 2012, 09:03
-- Wersja serwera: 5.5.12
-- Wersja PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `feb_cms2`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `desc` text COLLATE utf8_unicode_ci,
  `active` tinyint(1) DEFAULT '0',
  `page_id` int(11) NOT NULL,
  `name` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(15) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `alias` varchar(15) CHARACTER SET utf8 COLLATE utf8_polish_ci DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `groups`
--

INSERT INTO `groups` (`id`, `order`, `name`, `alias`, `created`, `modified`) VALUES
('4d530799-91d0-4249-8c38-0ff477ecc6b3', 0, 'Redaktorzy', 'editors', '2011-02-09 22:31:05', '2011-02-09 22:31:44'),
('4e76b6f4-6cea-102d-9f80-579a023712b2', 1, 'Administratorzy', 'admins', '2010-02-17 00:00:00', '2010-02-27 16:52:52'),
('4e7eaa5d-6cea-102d-9f80-579a023712b2', 2, 'Użytkownicy', 'users', '2010-02-17 00:00:00', '2010-02-27 16:42:40');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `group_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `user_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_user` (`group_id`,`user_id`),
  KEY `group_id` (`group_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `groups_users`
--

INSERT INTO `groups_users` (`id`, `group_id`, `user_id`) VALUES
('4f143333-4018-4630-ae98-109477ecc6b3', '4e76b6f4-6cea-102d-9f80-579a023712b2', '3a38ee92-6934-102d-9f80-579a023712b2'),
('4f142ba5-eb2c-48a1-82a4-109477ecc6b3', '4e76b6f4-6cea-102d-9f80-579a023712b2', '4e671a22-2db0-4f23-ac24-0fa877ecc6b3'),
('4eb14698-c4e0-4690-b7ae-076c77ecc6b3', '4e76b6f4-6cea-102d-9f80-579a023712b2', '4e782a14-b7d0-496c-89c1-01d877ecc6b3'),
('4f143337-5fa0-4567-8ad1-109477ecc6b3', '4e7eaa5d-6cea-102d-9f80-579a023712b2', '4e676fd8-67c4-4aa0-b1c6-13d077ecc6b3');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `helps`
--

CREATE TABLE IF NOT EXISTS `helps` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `modified` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Struktura tabeli dla  `i18n`
--

CREATE TABLE IF NOT EXISTS `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `foreign_key` char(36) COLLATE utf8_unicode_ci NOT NULL,
  `field` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `langs`
--

CREATE TABLE IF NOT EXISTS `langs` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `code` char(3) COLLATE utf8_unicode_ci NOT NULL,
  `lc` char(2) COLLATE utf8_unicode_ci NOT NULL COMMENT 'language code',
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Zrzut danych tabeli `langs`
--

INSERT INTO `langs` (`id`, `name`, `code`, `lc`, `active`) VALUES
(1, 'polski', 'pol', 'pl', 1),
(2, 'deutsch', 'deu', 'de', 0),
(3, 'Español', 'spa', 'es', 0),
(4, 'English', 'eng', 'en', 0),
(5, 'Slovakia', 'slo', 'sk', 0),
(6, 'Ukraine', 'ukr', 'ua', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  `option` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `model` varchar(50) DEFAULT NULL,
  `row_id` char(36) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


--
-- Struktura tabeli dla  `newsletters`
--

CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT '0',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `newsletter_messages`
--

CREATE TABLE IF NOT EXISTS `newsletter_messages` (
  `id` varchar(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(50) NOT NULL,
  `html_content` text,
  `content` text NOT NULL,
  `sender_name` varchar(40) NOT NULL,
  `sender_email` varchar(50) NOT NULL,
  `recipients` int(11) NOT NULL DEFAULT '0',
  `recipients_list` text,
  `progress` varchar(20) DEFAULT NULL COMMENT 'NULL - not in progress',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `static` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gallery` tinyint(1) DEFAULT '0',
  `comments` tinyint(1) NOT NULL DEFAULT '0',
  `lock` tinyint(1) DEFAULT '0',
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `lft` int(11) DEFAULT NULL,
  `rght` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `page_photos`
--

CREATE TABLE IF NOT EXISTS `page_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order` int(11) NOT NULL DEFAULT '1',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `page_photos`
--

INSERT INTO `page_photos` (`id`, `image`, `page_id`, `title`, `order`, `modified`, `created`) VALUES
(33, 'open-season-3-wallpaper_1.jpg', 4, '', 1, '2011-11-02 15:23:20', '2011-11-02 15:23:20'),
(30, 'open-season-3-wallpaper.jpg', 4, 'dsafd', 4, '2011-11-02 15:02:28', '2011-11-02 14:54:33'),
(31, 'tvnmeteo.jpg', 4, 'fa dsf asfdasf', 3, '2011-11-02 15:00:24', '2011-11-02 14:54:36'),
(32, '2001-2003_toyota_ipsum.jpg', 4, 'd asf qasdfasdf ', 2, '2011-11-02 15:00:20', '2011-11-02 14:54:37');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `created`, `modified`) VALUES
('4b7bc2f2-288c-4c07-b1a8-0a6c5d1a02a7', '*', '2010-02-17 11:20:34', '2010-02-17 11:20:34'),
('4e677176-3530-43b3-b67a-13d077ecc6b3', ':admin:settings:*', '2011-09-07 15:28:22', '2011-09-07 15:28:22'),
('4e677177-a768-4cdb-8b62-13d077ecc6b3', ':admin:users:index', '2011-09-07 15:28:23', '2011-09-07 15:28:23'),
('4e67731d-0da8-49ed-914e-13d077ecc6b3', ':*', '2011-09-07 15:35:25', '2011-09-07 15:35:25');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `requesters_permissions`
--

CREATE TABLE IF NOT EXISTS `requesters_permissions` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `permission_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `model` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Group',
  `row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `requester_permission` (`permission_id`,`model`,`row_id`),
  KEY `permission_id` (`permission_id`),
  KEY `model_row_id` (`model`,`row_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `requesters_permissions`
--

INSERT INTO `requesters_permissions` (`id`, `permission_id`, `model`, `row_id`, `created`, `modified`) VALUES
('4bd82273-9710-4c30-a08a-0c749ea437db', '4b7bc2f2-288c-4c07-b1a8-0a6c5d1a02a7', 'Group', '4e76b6f4-6cea-102d-9f80-579a023712b2', '2010-04-28 13:56:35', '2010-04-28 13:56:35'),
('4e677176-c92c-40d4-b755-13d077ecc6b3', '4e677176-3530-43b3-b67a-13d077ecc6b3', 'Group', '4e7eaa5d-6cea-102d-9f80-579a023712b2', '2011-09-07 15:28:22', '2011-09-07 15:28:22'),
('4e677177-c1cc-4cdc-8f92-13d077ecc6b3', '4e677177-a768-4cdb-8b62-13d077ecc6b3', 'Group', '4e7eaa5d-6cea-102d-9f80-579a023712b2', '2011-09-07 15:28:23', '2011-09-07 15:28:23'),
('4e677179-0aa8-4393-9f65-13d077ecc6b3', '4e677179-80a0-4e8f-8493-13d077ecc6b3', 'Group', '4e7eaa5d-6cea-102d-9f80-579a023712b2', '2011-09-07 15:28:25', '2011-09-07 15:28:25'),
('4e67797f-fa24-428f-9b95-13d077ecc6b3', '4e67731d-0da8-49ed-914e-13d077ecc6b3', 'Group', '4d530799-91d0-4249-8c38-0ff477ecc6b3', '2011-09-07 16:02:39', '2011-09-07 16:02:39');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `searchers`
--

CREATE TABLE IF NOT EXISTS `searchers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `row_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `selected` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `row_id` (`row_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `input_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'text',
  `editable` tinyint(1) NOT NULL DEFAULT '1',
  `weight` int(11) DEFAULT NULL,
  `params` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `title`, `description`, `input_type`, `editable`, `weight`, `params`) VALUES
(6, 'App.AppName', 'Feb-CMS', '', '', '', 1, 2, ''),
(7, 'SEO.tagline', 'Feb CMS - Marketing alternatywny', '', '', 'textarea', 1, 9, ''),
(8, 'App.WebSenderEmail', 'feb@cms.net.pl', '', '', '', 1, 1, ''),
(37, 'App.defaultLanguage', 'pl', '', '', '', 1, 17, ''),
(12, 'SEO.robots', 'index, follow', '', '', '', 1, 6, ''),
(13, 'SEO.keywords', 'Zarządzanie', '', '', 'textarea', 1, 5, ''),
(14, 'SEO.description', 'Strona CMS-a', '', '', 'textarea', 1, 7, ''),
(15, 'SEO.generator', 'Croogo - Content Management System', '', '', '', 0, 8, ''),
(16, 'Service.akismet_key', 'your-key', '', '', '', 1, 12, ''),
(17, 'Service.recaptcha_public_key', 'your-public-key', '', '', '', 1, 11, ''),
(18, 'Service.recaptcha_private_key', 'your-private-key', '', '', '', 1, 13, ''),
(19, 'Service.akismet_url', 'http://your-blog.com', '', '', '', 1, 10, ''),
(67, 'User.failed_login_limit', '5', 'Liczba możliwych nieudanych logowań', 'Blokada na 30min możliwości zalogowania do portalu', '', 1, 42, ''),
(22, 'Reading.per_page', '5', '', 'Ilość wpisów na stronie', '', 1, 14, ''),
(39, 'Analytics.datasource', 'google_analytics', '', '', '', 1, 18, ''),
(40, 'Analytics.email', 'statystyki@feb.net.pl', '', '', '', 1, 19, ''),
(41, 'Analytics.passwd', 'yf6rf23!WESUD', '', '', '', 1, 20, ''),
(42, 'Google.searchId', '004779266633206791730:fx9f1kx0lqa', '', '', '', 1, 21, ''),
(33, 'Maintenance.status', '1', '', 'Strona dostępna tylko dla administratorów', 'checkbox', 1, 16, ''),
(34, 'Maintenance.password', 'FEBtest123', '', 'Hasło dostępowe do strony', '', 1, 15, ''),
(35, 'App.WebSenderName', 'FEB CMS', '', '', '', 1, 4, ''),
(36, 'App.AdminEmail', 'admin@feb.net.pl', '', '', '', 1, 3, ''),
(43, 'Facebook.appId', '190127107724245', '', '', '', 1, 23, ''),
(44, 'Facebook.apiKey', 'aa169487144bf8102eab2e9d12634454', '', '', '', 1, 24, ''),
(45, 'Facebook.secret', 'aa169487144bf8102eab2e9d12634454', '', '', '', 1, 25, ''),
(46, 'Facebook.cookie', '1', '', '', 'checkbox', 1, 26, ''),
(47, 'Facebook.domain', 'kawa.pl', '', '', '', 1, 28, ''),
(48, 'Facebook.permissions', 'email,publish_stream', '', '', '', 1, 27, ''),
(51, 'Facebook.on', '0', 'Integracja z Facebookiem', '', 'checkbox', 1, 22, ''),
(68, 'Facebook.LikeBox', 'http://www.facebook.com/pages/Klub-Polska/102105043187662', 'URL LikeBoxa', '', '', 1, 43, ''),
(69, 'User.failed_login_duration', '300', 'Odstęp pomiędzy możliwością zalogowania po x krotnym wpisaniu niepoprawnego hasła', '', '', 1, NULL, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `slugs`
--

CREATE TABLE IF NOT EXISTS `slugs` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `locale` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `row_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_date` datetime DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Struktura tabeli dla  `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` char(36) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `facebook_id` bigint(13) unsigned DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(254) COLLATE utf8_unicode_ci NOT NULL,
  `login` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pass` char(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `remember` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu` tinyint(1) DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `failed_loginss` int(10) unsigned NOT NULL DEFAULT '0',
  `date_locked` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`),
  UNIQUE KEY `login_unique` (`login`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `facebook_id`, `active`, `email`, `login`, `pass`, `name`, `avatar`, `x`, `y`, `remember`, `menu`, `created`, `modified`, `failed_loginss`, `date_locked`) VALUES
('3a38ee92-6934-102d-9f80-579a023712b2', 0, 1, 'admin@feb.net.pl', 'admin', '1a6747eef12c2f0b7fc6fa326a441801fff14b1e', 'Admin', 'blockui.png', 0, 0, '7ac49c8f8f946e3d7692a569274aadcd3bc16da1', 1, '2009-10-30 14:09:30', '2012-01-17 08:15:50', 0, NULL),
('4e671a22-2db0-4f23-ac24-0fa877ecc6b3', 100001414898604, 1, 's.jach@feb.net.pl', NULL, '8cc111f2f058c989613eeae053dcc5286c594037', 'Slawomir', 'asertywnosc_1.jpg', NULL, NULL, '479751f4c0e24ac096ca67a1ff5405f0c8b11203', 1, '2011-09-07 09:15:46', '2012-01-17 08:15:56', 0, NULL),
('4e676fd8-67c4-4aa0-b1c6-13d077ecc6b3', NULL, 1, 'arek@dziki.eu', NULL, '8a1450cd2fb9c9938842d02211e009f54a2693f9', 'Arek', NULL, NULL, NULL, NULL, 1, '2011-09-07 15:21:28', '2012-01-16 15:24:55', 0, NULL),
('4e782a14-b7d0-496c-89c1-01d877ecc6b3', NULL, 1, 'd.czyz@feb.net.pl', NULL, '28c6fe234e0a9f685787282d499cb8ecbc00eca9', 'damian', NULL, NULL, NULL, '43ab8e47d0739018dbe7f0ddb58b12e0ed2bdede', 1, '2011-09-20 07:52:20', '2011-11-17 11:14:14', 0, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `users_logs`
--

CREATE TABLE IF NOT EXISTS `users_logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` char(36) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `really_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `requesters_permissions`
--
ALTER TABLE `requesters_permissions`
  ADD CONSTRAINT `requesters_permissions_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
