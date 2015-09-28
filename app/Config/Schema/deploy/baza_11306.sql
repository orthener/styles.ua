
ALTER TABLE `order_items` ADD `product_model` VARCHAR( 100 ) NOT NULL DEFAULT 'Product' AFTER `order_id` ;
ALTER TABLE `order_items` ADD `product_plugin` VARCHAR( 100 ) NOT NULL DEFAULT 'StaticProduct' AFTER `order_id` ;


