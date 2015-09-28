ALTER TABLE `commerce_orders` DROP `order_extra_id`;
ALTER TABLE `commerce_orders` DROP `order_extra_m2`;
ALTER TABLE  `commerce_orders` ADD  `provision` BOOLEAN NOT NULL COMMENT  'Flaga mówiąca czy do zamówienia dodawane jest 2% prowizji' AFTER  `vat`;
ALTER TABLE  `commerce_orders` CHANGE  `provision`  `provision` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT 'Flaga mówiąca czy do zamówienia dodawane jest 2% prowizji';
ALTER TABLE  `commerce_orders` ADD  `provision_total` DECIMAL( 8, 2 ) NOT NULL DEFAULT  '0' AFTER  `provision`;
ALTER TABLE  `commerce_orders` CHANGE  `provision_total`  `provision_total` DECIMAL( 8, 2 ) NULL DEFAULT  '0.00';
ALTER TABLE  `commerce_shipment_methods` CHANGE  `order`  `order` INT( 11 ) NOT NULL DEFAULT  '0';