

CREATE TABLE IF NOT EXISTS `sash_types_window_fittings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sash_type_id` int(10) unsigned NOT NULL,
  `window_fitting_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `window_configurations` ADD `warm_edges` TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER `roller_shutter_accessory_id`;

ALTER TABLE `window_colors` ADD `type` VARCHAR( 30 ) NULL AFTER `group`;

ALTER TABLE `window_colors` ADD `window_color_id` INT UNSIGNED NULL AFTER `id`;

DROP TABLE IF EXISTS `window_bar_type_widths`;
CREATE TABLE `window_bar_type_widths` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `window_bar_type_id` int(10) unsigned NOT NULL,
  `bicapsular` tinyint(1) DEFAULT NULL,
  `width_mm` smallint(6) NOT NULL COMMENT 'in mm',
  `price_white` decimal(6,2) unsigned DEFAULT NULL,
  `price_wooden` decimal(6,2) unsigned DEFAULT NULL,
  `price_wooden_2` decimal(6,2) unsigned DEFAULT NULL,
  `price_gold` decimal(6,2) unsigned DEFAULT NULL,
  `price_old_gold` decimal(6,2) unsigned DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Zrzut danych tabeli `window_bar_type_widths`
--

INSERT INTO `window_bar_type_widths` (`id`, `window_bar_type_id`, `bicapsular`, `width_mm`, `price_white`, `price_wooden`, `price_wooden_2`, `price_gold`, `price_old_gold`, `created`, `modified`) VALUES
(1, 1, NULL, 8, 23.00, NULL, NULL, 23.00, 23.00, '2012-08-02 14:53:44', '2013-03-20 18:38:50'),
(5, 1, NULL, 18, 23.00, 34.50, 36.80, 46.00, NULL, '2012-08-02 14:54:31', '2013-03-20 18:38:50'),
(7, 1, NULL, 26, 23.00, 46.00, 43.70, 69.00, NULL, '2012-12-17 18:45:11', '2013-03-20 18:38:50'),
(8, 1, NULL, 45, 39.10, 69.00, 69.00, NULL, NULL, '2012-12-17 18:45:11', '2013-03-20 18:38:50');


