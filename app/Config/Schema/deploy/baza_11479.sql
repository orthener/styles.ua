
CREATE TABLE IF NOT EXISTS `window_bar_type_widths` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `window_bar_type_id` int(10) unsigned NOT NULL,
  `width_mm` smallint(6) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `window_configuration_records` ADD `window_bar_type_width_id` INT UNSIGNED NULL AFTER `bar_style`;

ALTER TABLE `window_configuration_records` CHANGE `bar_style` `window_bar_type_id` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL COMMENT '1 - wewnątrzszybowe; 2 - naklejane';

ALTER TABLE `window_configuration_records` CHANGE `window_bar_type_id` `window_bar_type_id` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL;


