ALTER TABLE `news` ADD `head_code` TEXT NULL AFTER `ad_code2`;
ALTER TABLE `news_categories` ADD `head_code` TEXT NULL AFTER `ad_code2`;

ALTER TABLE  `menus` ADD  `mode` INT( 6 ) NOT NULL DEFAULT  '1' AFTER  `row_id`;
ALTER TABLE `menus` ADD `blink` TINYINT( 4 ) NOT NULL DEFAULT '0' AFTER `option` 