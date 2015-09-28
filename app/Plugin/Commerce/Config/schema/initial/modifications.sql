-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 10 Lip 2011, 07:18
-- Wersja serwera: 5.0.51
-- Wersja PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Struktura tabeli dla  `modifications`
--

CREATE TABLE IF NOT EXISTS `modifications` (
  `id` char(36) character set utf8 collate utf8_bin NOT NULL,
  `user_id` char(36) character set utf8 collate utf8_bin NOT NULL,
  `model` varchar(30) collate utf8_unicode_ci NOT NULL,
  `foreign_key` char(36) character set utf8 collate utf8_bin NOT NULL,
  `action` varchar(15) collate utf8_unicode_ci NOT NULL default 'edit',
  `user_details` mediumtext character set utf8 collate utf8_bin,
  `content_before` mediumtext character set utf8 collate utf8_bin NOT NULL,
  `content_after` mediumtext character set utf8 collate utf8_bin NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

