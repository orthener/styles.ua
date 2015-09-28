CREATE TABLE  `shipment_method_configs` (
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`shipment_method_id` INT( 10 ) UNSIGNED NOT NULL ,
`weight` DECIMAL( 8, 4 ) NOT NULL ,
`price` DECIMAL( 8, 2 ) NOT NULL ,
`tax_rate` DECIMAL( 2, 2 ) NOT NULL,
`created` DATETIME NOT NULL,
`modified` DATETIME NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ;

ALTER TABLE  `order_items` ADD  `weight` DECIMAL( 10, 4 ) NULL AFTER  `discount`;