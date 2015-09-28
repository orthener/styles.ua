

--
-- Struktura tabeli dla tabeli `window_colors_window_bar_types`
--

CREATE TABLE IF NOT EXISTS `window_colors_window_bar_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `window_color_id` int(10) unsigned NOT NULL,
  `window_bar_type_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `window_colors` ADD `group` VARCHAR( 20 ) NOT NULL DEFAULT 'window' AFTER `id` ;

ALTER TABLE `window_configurations` ADD `window_bars_color_id` INT UNSIGNED NULL AFTER `window_color_group_id` ;


