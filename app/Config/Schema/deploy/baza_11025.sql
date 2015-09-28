
ALTER TABLE `awning_configurations` ADD `roll_up_valance` BOOLEAN NULL DEFAULT NULL AFTER `valance_id`;



--
-- Struktura tabeli dla tabeli `awning_rollup_valance_prices`
--

CREATE TABLE IF NOT EXISTS `awning_rollup_valance_prices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `min_width` int(10) unsigned DEFAULT NULL,
  `max_width` int(10) unsigned DEFAULT NULL,
  `price` decimal(6,2) NOT NULL COMMENT 'unit price',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Zrzut danych tabeli `awning_rollup_valance_prices`
--

INSERT INTO `awning_rollup_valance_prices` (`id`, `min_width`, `max_width`, `price`) VALUES
(1, NULL, 230, 110.00),
(2, 231, 290, 140.00),
(3, 291, 350, 166.00),
(4, 351, 410, 195.00),
(5, 411, 470, 225.00),
(6, 471, 530, 255.00),
(7, 531, 590, 285.00);

ALTER TABLE `awning_lines` ADD `roll_up_valance` BOOLEAN NOT NULL DEFAULT FALSE AFTER `photo_id` ;

ALTER TABLE `awning_lines` CHANGE `roll_up_valance` `roll_up_valance` TINYINT UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `awning_mountings` ADD `img` VARCHAR( 255 ) NULL DEFAULT NULL AFTER `name`;

