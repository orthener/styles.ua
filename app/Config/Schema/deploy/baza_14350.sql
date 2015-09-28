
-- ALTER TABLE `window_layouts_variants_sizes` ADD `price` DECIMAL( 8, 2 ) UNSIGNED NULL AFTER `width_to`;

ALTER TABLE window_configurations DROP COLUMN roller_shutter_accessory_id ;

--
-- Struktura tabeli dla tabeli `window_configurations_roller_shutter_accessories`
--

CREATE TABLE IF NOT EXISTS `window_configurations_roller_shutter_accessories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `window_configuration_id` int(10) unsigned NOT NULL,
  `roller_shutter_accessory_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `primary2` (`window_configuration_id`,`roller_shutter_accessory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `sashes_layouts` ADD `split_sash_glass` TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER `layout`;