CREATE TABLE  `order_item_files` (
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
`order_item_id` INT( 10 ) UNSIGNED NOT NULL ,
`name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`desc` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
PRIMARY KEY (  `id` )
) ENGINE = INNODB;