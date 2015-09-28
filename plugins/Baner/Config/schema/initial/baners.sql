-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 16 Sie 2012, 14:22
-- Wersja serwera: 5.5.12
-- Wersja PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `feb_b4`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `baners`
--

CREATE TABLE IF NOT EXISTS `baners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `clicks_counter` int(10) NOT NULL DEFAULT '0',
  `shows_counter` int(11) NOT NULL DEFAULT '0',
  `html_code` text,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `clicks_limit` int(10) DEFAULT NULL,
  `date_limit` datetime DEFAULT NULL,
  `shows_limit` int(11) DEFAULT NULL,
  `group` varchar(60) NOT NULL,
  `publish_date` datetime DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;



-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `baner_clicks`
--

CREATE TABLE IF NOT EXISTS `baner_clicks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `baner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `baner_id` (`baner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;


-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `baner_shows`
--

CREATE TABLE IF NOT EXISTS `baner_shows` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `baner_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `baner_id` (`baner_id`),
  KEY `baner_id_2` (`baner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
