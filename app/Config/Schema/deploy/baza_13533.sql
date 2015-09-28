ALTER TABLE  `commerce_orders` ADD  `mounted` INT( 1 ) NULL DEFAULT  '0' AFTER  `vat` ,
ADD  `mounted_m2` VARCHAR( 10 ) NULL AFTER  `mounted` ,
ADD  `demounted` INT( 1 ) NULL DEFAULT  '0' AFTER  `mounted_m2` ,
ADD  `demounted_m2` INT( 10 ) NULL AFTER  `demounted` ,
ADD  `treatment` TINYINT( 1 ) NULL DEFAULT  '0' AFTER  `demounted_m2` ,
ADD  `treatment_m2` INT( 10 ) NULL AFTER  `treatment`;

ALTER TABLE  `commerce_orders` CHANGE  `treatment_m2`  `treatment_m2` FLOAT( 10 ) NULL DEFAULT NULL;
ALTER TABLE  `commerce_orders` CHANGE  `demounted_m2`  `demounted_m2` FLOAT( 10 ) NULL DEFAULT NULL;
ALTER TABLE  `commerce_orders` CHANGE  `mounted_m2`  `mounted_m2` FLOAT( 10 ) NULL DEFAULT NULL;

ALTER TABLE  `commerce_shipment_method_configs` CHANGE  `weight`  `weight` INT( 11 ) NOT NULL;
