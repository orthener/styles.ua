ALTER TABLE `window_configuration_records` ADD `vertical_bars` SMALLINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'szprosy pionowe' AFTER `handle_position` ,
ADD `horizontal_bars` SMALLINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'szprosy_poziome' AFTER `vertical_bars`;


ALTER TABLE `window_configuration_records` ADD `bar_style` BOOLEAN NULL DEFAULT NULL COMMENT '1 - wewnątrzszybowe; 2 - naklejane' AFTER `handle_position` ;

ALTER TABLE `window_configuration_records` CHANGE `bar_style` `bar_style` TINYINT UNSIGNED NULL DEFAULT NULL COMMENT '1 - wewnątrzszybowe; 2 - naklejane';

CREATE TABLE IF NOT EXISTS `window_bar_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `field_price` decimal(6,2) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `window_bar_types`
--

INSERT INTO `window_bar_types` (`id`, `name`, `field_price`, `created`, `modified`) VALUES
(1, 'Wewnątrzszybowe', 3.00, '2012-06-12 08:37:29', '2012-06-12 08:37:35'),
(2, 'Naklejane', 1.00, '2012-06-12 08:37:53', '2012-06-12 08:38:03');

INSERT INTO `i18n` (`locale`, `model`, `foreign_key`, `field`, `content`)
    SELECT 'pol', 'WindowBarType', id, 'name', `name` FROM `window_bar_types`;
