

ALTER TABLE `sashes_layouts` ADD `split_sash_glass` TINYINT UNSIGNED NOT NULL DEFAULT '0' AFTER `layout`;


ALTER TABLE `window_configurations` ADD `sash_division_position_mm` INT UNSIGNED NULL AFTER `height`;

