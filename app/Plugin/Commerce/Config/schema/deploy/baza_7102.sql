ALTER TABLE `addresses` CHANGE `phone` `phone` VARCHAR( 30 ) NOT NULL;

ALTER TABLE `orders` DROP `shipment_price_type`;

ALTER TABLE `order_items` DROP `price_type`;

ALTER TABLE `shipment_methods` DROP `price_type`;

