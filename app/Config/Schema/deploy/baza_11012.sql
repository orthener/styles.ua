
ALTER TABLE `window_lines` ADD `price_discount` TINYINT NOT NULL DEFAULT '0' AFTER `price_margin`;
ALTER TABLE `window_lines` CHANGE `price_discount` `price_discount` TINYINT( 4 ) UNSIGNED NOT NULL DEFAULT '0';


