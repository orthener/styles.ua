CREATE TABLE IF NOT EXISTS `products_sizes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Zrzut danych tabeli `products_sizes`
--

INSERT INTO `products_sizes` (`id`, `name`, `created`) VALUES
(16, 'M', '2013-11-04 08:46:50'),
(17, 'L', '2013-11-04 08:46:50'),
(18, 'XL', '2013-11-04 08:46:51'),
(19, 'XXL', '2013-11-04 08:46:51'),
(25, '34', '2013-11-04 08:47:45'),
(26, '48', '2013-11-04 08:49:02'),
(27, '50', '2013-11-04 08:49:02'),
(28, '52', '2013-11-04 08:49:02'),
(29, '54', '2013-11-04 08:49:02'),
(30, '56', '2013-11-04 08:49:02');