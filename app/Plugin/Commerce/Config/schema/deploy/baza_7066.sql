--
-- Struktura tabeli dla  `affiliate_programs`
--

CREATE TABLE IF NOT EXISTS `affiliate_programs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `minimum` decimal(10,2) NOT NULL,
  `discount` int(3) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `affiliate_programs`
--

INSERT INTO `affiliate_programs` (`id`, `name`, `minimum`, `discount`) VALUES
(4, 'Klient', 1000.00, 1),
(5, 'Sta³y Klient', 10000.00, 5);

ALTER TABLE  `customers` ADD  `discount` INT( 3 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  'Rabat, wartosci procentowe od 0-100' AFTER  `invoice_identity_id`